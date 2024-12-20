@props(['disabled' => false, 'value' => ''])

<input value="{{ $value }}" @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-md border border-neutral-300 bg-neutral-50 px-2 py-2 text-sm
 disabled:cursor-not-allowed
disabled:opacity-75 dark:border-neutral-700 dark:bg-neutral-900/50 ']) }}>
