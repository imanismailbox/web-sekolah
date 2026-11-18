@props(['icon' => 'file-text', 'title', 'message' => null])
<div {{ $attributes->merge(['class' => 'flex flex-col items-center rounded-xl border border-dashed border-brand-200 bg-white px-6 py-14 text-center']) }}>
    <span class="grid size-14 place-items-center rounded-full bg-brand-50 text-brand-600">
        <x-site-icon :name="$icon" class="size-7" />
    </span>
    <p class="mt-4 font-display text-lg font-semibold text-ink">{{ $title }}</p>
    @if ($message)
        <p class="mt-1 max-w-md text-sm text-muted">{{ $message }}</p>
    @endif
    {{ $slot }}
</div>
