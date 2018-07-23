<div class="ui secondary menu">
    <a href="{{ route('admin.users.index') }}" class="item {{ Request::is('admin/users*') ? 'active' : null }}">Benutzer</a>
    <a href="{{ route('admin.config.index') }}" class="item {{ Request::is('admin/config*') ? 'active' : null }}">Konfiguration</a>
</div>
<div class="ui divider dotted"></div>