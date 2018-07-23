@if($paginator->lastPage() > 1)
    <div class="ui pagination menu">
        <a href="{{ $paginator->previousPageUrl() }}" class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} item">
            Zurück
        </a>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <a href="{{ $paginator->url($i) }}" class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }} item">
                {{ $i }}
            </a>
        @endfor
        <a href="{{ $paginator->nextPageUrl() }}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} item">
            Weiter
        </a>
    </div>
@endif
