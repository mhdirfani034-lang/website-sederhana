@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        @if ($paginator->onFirstPage())
            <span class="page-button is-disabled" aria-disabled="true" aria-label="Sebelumnya">←</span>
        @else
            <a class="page-button" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-ellipsis" aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-button is-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="page-button" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="page-button" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">→</a>
        @else
            <span class="page-button is-disabled" aria-disabled="true" aria-label="Berikutnya">→</span>
        @endif
    </nav>
@endif
