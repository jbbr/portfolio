<div class="navigation">
    <div class="ui list">
        <div><a href="{{ route('portfolios.index') }}" class="{{ Request::is('portfolios*') ? 'active' : null }}">Portfolio</a></div>
        <div><a href="{{ route('export.index') }}" class="{{ Request::is('export*') ? 'active' : null }}">Ausgabe</a></div>
        <div><a href="{{ route('media.index') }}" class="{{ Request::is('media*') ? 'active' : null }}">Mediathek</a></div>
        <div><a href="{{ route('tags.index') }}" class="{{ Request::is('tags*') ? 'active' : null }}">Schlagwörter</a></div>
        @if(Auth::user()->isAdmin())
            <div><a href="{{ route('admin.users.index') }}" class="{{ Request::is('admin*') ? 'active' : null }}">Administration</a></div>
        @endif
    </div>
</div>
