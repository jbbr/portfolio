@if ($paginator->lastPage() > 1)
    <div class="ui pagination menu">
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <a href="{{ $paginator->url($i) }}" class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }} item">
                {{ $i }}
            </a>
        @endfor
    </div>
@endif