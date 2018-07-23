<div class="ui secondary menu">
    <a href="{{ route('profile.index') }}" class="item {{ Request::is('profile*') ? 'active' : null }}">Persönliches Profil</a>
    <a href="{{ route('locations.index') }}" class="item {{ Request::is('locations*') ? 'active' : null }}">Lernorte</a>
    <a href="{{ route('portfolios.arrange') }}" class="item {{ Request::is('portfolios*') ? 'active' : null }}">Aufgabenbereiche</a>
    <a href="{{ route('publish.profile.tree') }}" class="item {{ Request::is('publish*') ? 'active' : null }}">Öffentliche Freigaben</a>
</div>
<div class="ui divider dotted"></div>
