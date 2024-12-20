
<div x-data="{ todoID: '{{ $todo->id }}' }" wire:key="{{ $todo->id }}" class="col-span-1 px-5 py-6 mb-5 border-t-2 border-neutral-600 dark:border-neutral-700 todo card hover:shadow">

    <div class="flex items-start justify-between gap-4">

        <!-- Left Section: Checkbox and Title -->
        <div class="flex items-center flex-1 gap-3">

            <!-- Checkbox to toggle completion -->
            @if($todo->complated)
                <x-check-box wire:click="toggle({{ $todo->id }})" :checked="true" />
            @else
                <x-check-box wire:click="toggle({{ $todo->id }})" />
            @endif


            <!-- Title Display or Edit Input -->
            <template x-if="todoID == $wire.editingTodoId" >
                <div class="w-1/4">

                    <div class="flex flex-col">

                        <x-input-label for="upd_title" class="m-1 mb-0"> Title </x-input-label>
                        <x-text-input wire:model="upd_title" type="text" placeholder="Title..."  />
                        @error('upd_title')
                        <x-input-error :messages="$errors->get('upd_title')" class="mt-1" />
                        @enderror

                    </div>

                    <div class="flex flex-col">

                        <x-input-label for="upd_description" class="m-1 mb-0"> Description </x-input-label>
                        <x-textarea-input wire:model='upd_description' type="text" id="upd_description" placeholder="description.." />
                        @error('upd_description')
                        <x-input-error :messages="$errors->get('upd_description')" />
                        @enderror

                    </div>

                </div>
            </template>

            <template x-if="todoID !== $wire.editingTodoId">
                <div>

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $todo->title }}
                    </h3>

                    <h3 class="font-semibold text-gray-600 dark:text-gray-200">
                        {{ $todo->description }}
                    </h3>

                </div>
            </template>
        </div>


        <!-- Right Section: Action Buttons -->
        <div class="flex items-center gap-2">

            <template x-if="todoID == $wire.editingTodoId">
                <div class="flex items-center gap-3">

                    <!-- Update Button -->
                    <button wire:click="update({{ $todo->id }})" class="px-4 py-2 font-semibold text-white bg-teal-500 rounded hover:bg-teal-600">
                        Update
                    </button>

                    <!-- Cancel Button -->
                    <button x-on:click="$wire.editingTodoId = '0'" class="px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600">
                        Cancel
                    </button>

                </div>
            </template>


            <template x-if="todoID !== $wire.editingTodoId">
                <div class="flex items-center gap-3">

                    <!-- Edit Button -->
                    <button
                    x-on:click="

                        $wire.editingTodoId = '{{ $todo->id }}';
                        $wire.upd_title = '{{ $todo->title }}';
                        $wire.upd_description = '{{ $todo->description }}';

                    "

                        class="text-gray-500 hover:text-gray-700">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>

                    <!-- Delete Button -->
                    <button wire:click="delete({{ $todo->id }})" class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </div>
            </template>


        </div>
    </div>

    <!-- Created At -->
    <span class="block mt-2 text-xs text-gray-500">
        {{ $todo->created_at->format('M d, Y') }}
    </span>

</div>
