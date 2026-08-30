@props(['title', 'value', 'subtitle', 'icon', 'iconBg' => 'bg-blue-50', 'iconColor' => 'text-blue-600'])

<div class="bg-white rounded-[20px] p-5 shadow-sm border border-gray-100 flex flex-col justify-between h-full">
    <div class="flex justify-between items-start mb-4">
        <h3 class="text-sm font-medium text-gray-500">{{ $title }}</h3>
        <div class="w-10 h-10 {{ $iconBg }} {{ $iconColor }} rounded-full flex items-center justify-center shrink-0">
            {!! $icon !!}
        </div>
    </div>
    <div>
        <div class="text-3xl font-bold text-gray-900 mb-1">{{ $value }}</div>
        <p class="text-xs text-gray-400">{{ $subtitle }}</p>
    </div>
</div>
