@props(['iconBg' => 'bg-teal-600', 'textColor' => 'text-teal-800', 'size' => 'text-2xl'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }} style="display: flex; align-items: center; gap: 10px;">
    {{-- Icon Chef Hat (SVG Puffy & Professional) --}}
    <div class="{{ $iconBg }} p-2 rounded-xl text-white flex items-center justify-center"
         style="width: 42px; height: 42px; flex-shrink: 0; background-color: #0d9488; border-radius: 12px;">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px;">
            <path d="M6 13.8a4.5 4.5 0 1 1 2.6-8.3 4.5 4.5 0 1 1 6.8 0 4.5 4.5 0 1 1 2.6 8.3" />
            <path d="M6 13.8h12" />
            <path d="M7 14v4c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2v-4" />
        </svg>
    </div>

    {{-- Text Logo --}}
    <span class="{{ $size }} font-bold {{ $textColor }} font-display italic"
          style="white-space: nowrap; font-family: 'Playfair Display', serif; font-style: italic; color: #115e59; font-size: 1.6rem;">
        Guhresto
    </span>
</div>
