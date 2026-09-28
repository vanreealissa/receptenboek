@if ($paginator->hasPages())
    <nav class="row between" style="margin-top:28px" aria-label="Paginering">
        @if ($paginator->onFirstPage())
            <span class="btn secondary small" aria-disabled="true" style="opacity:.5">← Vorige</span>
        @else
            <a class="btn secondary small" href="{{ $paginator->previousPageUrl() }}" rel="prev">← Vorige</a>
        @endif

        <span class="muted">Pagina {{ $paginator->currentPage() }} van {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="btn secondary small" href="{{ $paginator->nextPageUrl() }}" rel="next">Volgende →</a>
        @else
            <span class="btn secondary small" aria-disabled="true" style="opacity:.5">Volgende →</span>
        @endif
    </nav>
@endif
