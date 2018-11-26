<div class="entry-indiv">
    <div class="entry-head">
        <div class="title">{{ ( $loop->index + 1 ) }}_{{ $_entry->title }}</div>
        <div class="sub_title">Aufgabenbereich: {{ $_entry->portfolio->sort }}. {{ $_entry->portfolio->title }}</div>

        <div class="hr"></div>

        <div class="tags-list">
            <div class="title">Schlagwörter</div>

            @foreach($_entry->tags as $tag)
                <div class="tag">{{ $tag->name }}</div>
            @endforeach
            <div class="clearer"></div>
        </div>

        <div class="hr"></div>

        <div class="extra">
            {{ \Carbon\Carbon::parse($_entry->date)->format('d.m.Y') }}
            @if($_entry->date_to)
                -
                {{ \Carbon\Carbon::parse($_entry->date_to)->format('d.m.Y') }}
            @endif
            @if(!empty($_entry->location()->first()))
                // {{ $_entry->location()->first()->name }}
            @endif
        </div>
    </div>
    <div class="description">
        {!! str_replace("src=\"/storage/media/", "src=\"". url()->to("/") . "/storage/media/", $_entry->description) !!}
    </div>

    @include('export.pdf.entry-media')



</div>
