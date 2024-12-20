<?php

namespace App\Livewire\Pages\PlayGround;

use App\Models\PlayGround\Todo as PlayGroundTodo;
use App\Models\PlayGround\TodoImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class TodoWithImage extends Component
{

    use WithPagination;

// --------------------------------------------------------------------------------------------------------------------

    public $title;
    public $description;
    public $images;


    #[Rule('nullable|string')]
    public $search;

    public function create(){

        $data = $this->validate([
            'title' => 'required|min:3',
            'description' => 'nullable|min:10',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['user_id']=Auth::user()->id;
        $todo = PlayGroundTodo::create($data);

        DB::beginTransaction();

        try {


            // Handle images upload
            $manager = new ImageManager(new Driver());
            if (!empty($this->images)) {

                    foreach ($this->images as $image) {
                            // Generate the directory path
                            $directoryPath = 'todos/' . $todo->user_id . '/' . $todo->id . '/images';

                            // Ensure the directory exists
                            if (!Storage::disk('public')->exists($directoryPath)) {
                                Storage::disk('public')->makeDirectory($directoryPath, 0755, true);
                            }

                            // Generate the full image path
                            $imagePath = $directoryPath . '/' . uniqid('todo_') . '.' . $image->getClientOriginalExtension();

                            // Read the image using Intervention Image
                            $img = $manager->read($image);


                            // Save the image with compression
                            $fullPath = Storage::disk('public')->path($imagePath);
                            $img->save($fullPath, 80);

                            // Get the public URL of the stored image
                            $imageUrl = Storage::url($imagePath);

                            // Save the image URL in the database
                            TodoImage::create([
                                'todo_id' => $todo->id,
                                'image_url' => $imageUrl,
                                'created_at' => now(),
                                'created_by' => Auth::user()->id,
                            ]);
                    }
            }

            $this->reset();
            $this->resetPage();
            DB::commit();

        $this->dispatch('alert',type:'success',title:'To do Successfully',position:'top-center');

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('alert',type:'error',title:$e->getMessage(),position:'top-center',timer:'15000');

        }

    }

// --------------------------------------------------------------------------------------------------------------------

    public $upd_title;
    public $upd_description;
    public $editingTodoId = null; // Track which todo is being edited

    public function edit(PlayGroundTodo $todo)
    {
        // Set the editing ID and populate fields with the current data
        $this->editingTodoId = $todo->id;
        $this->upd_title = $todo->title;
        $this->upd_description = $todo->description;
    }
    public function update(PlayGroundTodo $todo)
    {
        // Validate Livewire public properties
        $this->validate([
            'upd_title' => 'required|min:3',
            'upd_description' => 'nullable|min:10',
        ]);

        // Authorization check before proceeding
        if ($todo->user_id !== Auth::id()) {
            $this->dispatch('alert', [
                'type' => 'error',
                'title' => 'Unauthorized action. This To-Do does not belong to you.',
                'position' => 'top-center',
            ]);
            return;
        }

        try {
            DB::beginTransaction();

            // Update the To-Do record
            $todo->update([
                'title' => $this->upd_title,
                'description' => $this->upd_description,
            ]);

            DB::commit();

            // Reset the input fields after successful update
            $this->reset();

            // Success alert
            $this->dispatch('alert',type:'success',title:'To do Successfully deleted',position:'top-center');

        } catch (\Exception $e) {
            DB::rollBack();

            // Error alert
            $this->dispatch('alert',type:'error',title:$e->getMessage(),position:'top-center',timer:'15000');

        }
    }

    public function cancelEdit()
    {
        $this->reset(['editingTodoId', 'upd_title', 'upd_description']);
    }


// --------------------------------------------------------------------------------------------------------------------

    public function delete(PlayGroundTodo $todo){
        DB::beginTransaction();


        try {

            // Authorization check before proceeding
            if ($todo->user_id !== Auth::id()) {
                $this->dispatch('alert', [
                    'type' => 'error',
                    'title' => 'Unauthorized action. This To-Do does not belong to you.',
                    'position' => 'top-center',
                ]);
                return;
            }
            // Define the folder path where the specific car's images are stored
            $imageFolderPath = 'todos/' . $todo->user_id . '/' . $todo->id;

            // Check if the folder exists, then delete the entire folder for that car
            if (Storage::disk('public')->exists($imageFolderPath)) {
                Storage::disk('public')->deleteDirectory($imageFolderPath);
            }


            $todo->images()->delete();
            $todo->delete();

            DB::commit();
            $this->dispatch('alert',type:'success',title:'To do Successfully deleted',position:'top-center');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alert',type:'error',title:$e->getMessage(),position:'top-center',timer:'15000');

        }
    }


// --------------------------------------------------------------------------------------------------------------------

    public function toggle(PlayGroundTodo $todo){
        DB::beginTransaction();

        try {

            $todo->complated = !$todo->complated;
            $todo->save();
            DB::commit();
            // $this->dispatch('alert',type:'success',title:'Successfully ',position:'top-center');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alert',type:'error',title:$e->getMessage(),position:'top-center',timer:'15000');

        }
    }

// --------------------------------------------------------------------------------------------------------------------


    #[Computed()]
    public function list(){
        return PlayGroundTodo::where('user_id', Auth::user()->id)->where('title', 'like', '%' . $this->search . '%')->with('images')->paginate(5);
    }


// --------------------------------------------------------------------------------------------------------------------

    public function render()
    {
        return view('livewire.pages.play-ground.todo');
    }
}
