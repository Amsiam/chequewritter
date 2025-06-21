<x-filament-panels::page>

    <form wire:submit="save">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            @foreach ($formFields as $field)
                <div>
                    <label for="{{ $field['name'] }}"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                    @if ($field['type'] === 'text')
                        <input type="text" id="{{ $field['name'] }}" wire:model="form.{{ $field['name'] }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @elseif ($field['type'] === 'number')
                        <input type="number" step="any" id="{{ $field['name'] }}"
                            wire:model="form.{{ $field['name'] }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @elseif ($field['type'] === 'checkbox')
                        <input type="checkbox" id="{{ $field['name'] }}" wire:model="form.{{ $field['name'] }}"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-offset-gray-800">
                    @endif
                </div>
            @endforeach

        </div>
        <button style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
            class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">Save</button>
    </form>


</x-filament-panels::page>
