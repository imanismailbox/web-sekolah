@php
    /** @var \App\Models\AlbumPhoto $record */
    $record = $getRecord();
    $state = $getState();
    $url = $state ? \Illuminate\Support\Facades\Storage::disk('public')->url($state) : null;
@endphp

@if ($url)
    @if ($record->isVideo())
        <div class="relative h-20 w-28 overflow-hidden rounded-lg bg-gray-900">
            <video src="{{ $url }}#t=0.1" muted playsinline preload="metadata" class="h-full w-full object-cover"></video>
            <span class="pointer-events-none absolute inset-0 grid place-items-center bg-black/30 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6" aria-hidden="true">
                    <polygon points="6 3 20 12 6 21 6 3" />
                </svg>
            </span>
        </div>
    @else
        <img src="{{ $url }}" alt="{{ $record->caption ?? '' }}" class="h-20 w-auto rounded-lg object-cover" />
    @endif
@endif
