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

class Todo extends Component
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

        DB::beginTransaction();

        try {

            $todo = PlayGroundTodo::create($data);
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
    public $editingTodoId;
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

        DB::beginTransaction();

        try {

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
