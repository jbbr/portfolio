@extends('layouts.app')

@section('title', 'Lernorte')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Lernorte',
        'divider' => false,
        'create' => route('locations.create'),
        'help' => Config::get('help.profile.locations'),
        'addtext' => 'Lernort hinzufügen',
    ])
    <p>Übersicht Deiner Lernorte</p>
    <div class="ui divider dotted"></div>
    @include('profile.partials.tabs')
    <div class="ui divided items">
        @forelse($locations as $location)
            <div class="item">
                <div class="content">
                    <div class="header">
                        <h3>
                            <a href="{{ route('locations.show', $location->id) }}">{{ $location->name }}</a>
                            {{ $location->type != 'general' ? '(' . LocationAdditions::getTypeName($location->type) . ')' : null }}
                        </h3>
                    </div>
                    <div class="actions">
                        <div class="actions">
                            <form method="POST" action="{{ route('locations.destroy', $location->id) }}"
                                  onsubmit="return confirm('Lernort wirklich löschen?')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="ui icon right floated button" data-content="Löschen">
                                    <i class="trash icon"></i>
                                </button>
                            </form>
                            <a class="ui icon right floated button" href="{{ route('locations.edit', $location->id) }}" data-content="Bearbeiten">
                                <i class="edit icon"></i>
                            </a>
                        </div>
                    </div>
                    <div class="meta">
                        @include('locations.partials.details')
                    </div>
                </div>
            </div>
        @empty
            <div class="cta-text">
                <h2 class="green colored">Du hast noch keine Lernorte.</h2>
                <p>Lege einen neuen Lernort an oder klicke auf Hilfe um mehr über Lernorte zu erfahren.</p>
                <a class="ui primary button" href="{{ route('locations.create') }}">Lernort anlegen</a>
            </div>
        @endforelse
    </div>
@endsection
