@props(['active' => false, 'icon' => ''])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-2.5 rounded-lg bg-blue-100 text-blue-700 font-semibold text-sm transition'
            : 'flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-500 font-medium text-sm hover:bg-gray-100 hover:text-gray-900 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="{{ $active ? 'text-blue-600' : 'text-gray-400' }} shrink-0">
            {!! $icon !!}
        </span>
    @endif
    {{ $slot }}
</a>
