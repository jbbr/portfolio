@if($paginator->last_page > 1)
    <div class="ui pagination menu">
        <a href="{{ $paginator->prev_page_url }}" class="{{ ($paginator->current_page == 1) ? ' disabled' : '' }} item">
            Zurück
        </a>
        @for ($i = 1; $i <= $paginator->last_page; $i++)
            <a href="{{ $paginator->url . "?page=" . $i . $paginator->query_string }}" class="{{ ($paginator->current_page == $i) ? ' active' : '' }} item">
                {{ $i }}
            </a>
        @endfor
        <a href="{{ $paginator->next_page_url }}" class="{{ ($paginator->current_page == $paginator->last_page) ? ' disabled' : '' }} item">
            Weiter
        </a>
    </div>
@endif
