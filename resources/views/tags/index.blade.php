@extends('layouts.app')

@section('title', 'Schlagwörter')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => 'Schlagwörter',
        'divider' => false,
        'help' => Config::get('help.tags'),
    ])
    <p>
        Hier kannst Du Schlagwörter erstellen und bearbeiten.
    </p>
    <div class="ui divider dotted"></div>
    <div class="ui divider hidden"></div>
    <h2 class="green colored">Neues Schlagwort</h2>
    <form method="POST" action="{{ route('tags.store') }}" class="ui form">
        {{ csrf_field() }}
        <div class="fields">
            <div class="four wide field">
                <input type="text" name="name" placeholder="Name">
            </div>
            <div class="two wide field">
                <button type="submit" class="ui primary button">Hinzufügen</button>
            </div>
        </div>
    </form>
    <div class="ui divider dotted"></div>
    <div class="ui divider hidden"></div>
    @if(count($tags) > 0)
        <h2 class="green colored">Vorhandene Schlagwörter verwalten</h2>
        <div class="ui grid">
            <div class="{{ $tags->count() > 1 ? "twelve" : "six" }} wide column">
                @include('partials.pagination', ['paginator' => $tags])
                <table class="ui very basic compact table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="center aligned">Verwendungen</th>
                        @if($tags->count() > 1)
                            <th>Name</th>
                            <th class="center aligned">Verwendungen</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        @if($loop->iteration%2 || $loop->first)
                        <tr>
                        @endif
                            <td>
                                <a href="{{ route('tags.show', $tag->id) }}"><strong>{{ $tag->name }}</strong></a><br/>
                                <form onsubmit="return confirm('Schlagwort wirklich löschen?')"
                                      action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="button link">Löschen</button>
                                    <a>|</a>
                                    <a href="{{ route('tags.edit', $tag->id) }}">Bearbeiten</a>
                                </form>
                            </td>
                            <td class="center aligned">
                                <a href="{{ route('tags.show', $tag->id) }}">
                                    <div class="ui large label" data-content="Anzahl der Verwendungen">
                                        {{ $tag->uses() }}
                                    </div>
                                </a>
                            </td>
                        @if($loop->iteration%1 || $loop->last)
                        </tr>
                        @endif

                    @endforeach
                </table>
                @include('partials.pagination', ['paginator' => $tags])
            </div>
        </div>
    @else
        <div class="cta-text">
            <h2 class="green colored">Du hast noch keine Schlagwörter.</h2>
            <p>
                Lege ein neues Schlagwort an oder klicke auf Hilfe um mehr über Schlagwörter zu erfahren.
            </p>
        </div>
    @endif
@endsection
