
{{-- Full CRUD
cons :
the update is so slow as we get the data from the server first
--}}




<div  class="flex flex-col border rounded-md group border-neutral-300 bg-neutral-50 text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-300">



        <header id="header" class="p-6 border-b-2 border-neutral-600 dark:border-neutral-700">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-plus fa-beat-fade"></i>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Create New Todo</h2>
            </div>

            <p class="mt-2 text-sm text-pretty">
                Create your to-do list and start tackling your tasks today! Add, edit
                and delete your tasks, and mark them as completed.
            </p>
        </header>



        <article id="article" class="p-6 border-b-2 border-neutral-600 dark:border-neutral-700">
            <form>

                    <div class="flex flex-col gap-3">

                        <div class="flex flex-col max-w-md gap-2">
                            <x-input-label for="title" class="m-1 mb-0">Title </x-input-label>
                            <x-text-input wire:model='title' type="text" id="title" placeholder="Title.." />
                            @error('title')
                            <x-input-error :messages="$errors->get('title')" />
                            @enderror
                        </div>

                        <div class="flex flex-col max-w-md gap-2">
                            <x-input-label for="description" class="m-1 mb-0">Description </x-input-label>
                            <x-textarea-input wire:model='description' type="text" id="description" placeholder="description.." />
                            @error('description')
                            <x-input-error :messages="$errors->get('description')" />
                            @enderror
                        </div>

                    </div>

                <div class="flex items-center gap-2 mt-5">
                    <x-primary-button wire:click.prevent="create" type="submit" >Create +</x-primary-button>
                    <x-action-message class="" on="submit">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>

            </form>
        </article>




        <div id="search-box" class="flex flex-col items-center justify-center px-2 my-4">

            <div class="flex items-center justify-center gap-3">
                <i class="fa-solid fa-magnifying-glass fa-beat-fade"></i>
                <x-text-input wire:model.live.debounce.500ms='search'  type="text" placeholder="Search..." />
            </div>

        </div>



        <div id="todos-list">
            @foreach ($this->list() as $todo)
                @include('livewire.pages.play-ground.includes.todo-card', ['todo' => $todo])
            @endforeach

            <div class="px-6 my-2">
                {{ $this->list()->links() }}
            </div>
        </div>


    </div>
