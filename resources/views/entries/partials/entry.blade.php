<div class="column" data-location="{{ $entry->location ? $entry->location->name : null }}">
    <a href="{{ route('portfolios.entries.show', [$portfolio->id, $entry->id]) }}">
        <div class="ep entry ui card">
            <div class="image">
                @if($entry->mediaInfos->first())
                    <img src="{{ $entry->mediaInfos->first()->media->getImagePath('328x164') }}">
                @endif
            </div>
        </div>
    </a>
    <div class="ep entry extra">
        <div class="clear">
            <div class="date"><b>Datum:</b> {{ $entry->date }}</div>
            @if($entry->location)
                <div class="location"><b>Lernort:</b> {{ $entry->location->name }}</div>
            @endif
        </div>
        <div class="title"><b>Mein Eintrag:</b> <br/>{{ $entry->title }}</div>
    </div>
</div>
