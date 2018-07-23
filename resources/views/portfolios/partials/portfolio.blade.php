<div class="column" data-location="{{ implode('|', $portfolio->locations()->pluck('name')->toArray()) }}">
    <a href="{{ route('portfolios.entries.index', [$portfolio->id]) }}">
        <div class="ep ui card" data-content="Aufgabenbereich">
            <div class="portfolio image">
                @if($portfolio->mediaInfos()->first())
                    <img src="{{ $portfolio->mediaInfos()->first()->media->getImagePath('330x100') }}">
                @endif
            </div>
            <div class="content">
                <div class="header"><span class="fit-font">{{ $portfolio->sort }}. {{ $portfolio->title }}</span></div>
                <div class="description"><span class="fit-font">{{ $portfolio->subtitle }}</span></div>
            </div>
        </div>
    </a>
    <div class="ep card extra">
        <div class="help pointer" onclick="portfolio.help({{ $portfolio->id }})" data-content="Beschreibung des Aufgabenbereichs"></div>
        @lang('portfolios.entries')
            <div class="count">{{ $portfolio->entries->count() }}</div>
    </div>
</div>
