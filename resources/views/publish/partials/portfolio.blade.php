<div class="column">
    <a href="{{ route('publish.entries.list', [$urlkey, $portfolio->id]) }}">
        <div class="ep ui card" data-content="Aufgabenbereich">
            <div class="portfolio image">
                @if($portfolio->mediaInfos()->first())
                    <img src="{{ $portfolio->mediaInfos()->first()->media->getImagePath('330x100') }}">
                @endif
            </div>
            <div class="content">
                <div class="header">{{ $portfolio->sort }}. {{ $portfolio->title }}</div>
                <div class="description">{{ $portfolio->subtitle }}</div>
            </div>
        </div>
    </a>
    <div class="ep card extra">
        <div class="help pointer" onclick="portfolio.help({{ $portfolio->id }})" data-content="Beschreibung des Aufgabenbereichs"></div>
        @lang('portfolios.entries')
            <div class="count">{{ $portfolio->entries->count() }}</div>
    </div>
</div>
