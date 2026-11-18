@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex items-center justify-between gap-4">
        <p class="text-sm text-muted">
            Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </p>
        <ul class="flex items-center gap-1.5">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="grid size-10 place-items-center rounded-full text-brand-200" aria-hidden="true"><x-site-icon name="chevron-left" class="size-5" /></span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="grid size-10 place-items-center rounded-full bg-white text-brand-700 shadow-sm hover:bg-brand-50"><x-site-icon name="chevron-left" class="size-5" /><span class="sr-only">Sebelumnya</span></a>
                @endif
            </li>
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="hidden px-1 text-muted sm:block">{{ $element }}</li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="hidden sm:block">
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="grid size-10 place-items-center rounded-full bg-brand-600 font-display text-sm font-semibold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="grid size-10 place-items-center rounded-full bg-white font-display text-sm font-medium text-ink shadow-sm hover:bg-brand-50">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="grid size-10 place-items-center rounded-full bg-white text-brand-700 shadow-sm hover:bg-brand-50"><x-site-icon name="chevron-right" class="size-5" /><span class="sr-only">Berikutnya</span></a>
                @else
                    <span class="grid size-10 place-items-center rounded-full text-brand-200" aria-hidden="true"><x-site-icon name="chevron-right" class="size-5" /></span>
                @endif
            </li>
        </ul>
    </nav>
@endif
