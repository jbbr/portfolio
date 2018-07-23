<div class="column">
    <a href="{{ route('portfolios.entries.create', $portfolio->id) }}">
        <div class="ep entry ui card" data-content="Neuen Eintrag erstellen">
            <div class="plus">+</div>
        </div>
    </a>
    <div class="ep entrycreate extra">
        <a href="{{ route('portfolios.entries.create', $portfolio->id) }}" class="ui primary button">@lang('portfolios.add_entries')</a>
    </div>
</div>
