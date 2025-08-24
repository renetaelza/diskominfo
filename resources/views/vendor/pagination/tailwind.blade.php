@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center mt-6">
    <div class="inline-flex space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <span class="btn-filter cursor-not-allowed opacity-50">
            &laquo;
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-filter">
            &laquo;
        </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <span class="btn-filter cursor-default opacity-70">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span class="btn-filter bg-[#18417F] text-white border-[#18417F] cursor-default">
            {{ $page }}
        </span>
        @else
        <a href="{{ $url }}" class="btn-filter">{{ $page }}</a>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-filter">
            &raquo;
        </a>
        @else
        <span class="btn-filter cursor-not-allowed opacity-50">
            &raquo;
        </span>
        @endif
    </div>
</nav>
@endif
