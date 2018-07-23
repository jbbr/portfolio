@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Aufgabenbereiche',
        'divider' => false,
        'help' => Config::get('help.profile.portfolios'),
    ])
    <p>Hier kannst Du Aufgabenbereiche hinzufügen, bearbeiten, teilen und importieren.</p>
    <div class="ui divider dotted"></div>
    @include('profile.partials.tabs')
    <div class="checklist">
        <form method="POST" action="{{ route('portfolios.multiedit') }}">
            {{ csrf_field() }}
            <div class="ui middle aligned grid">
                <div class="equal width row">
                    <div class="column">
                        <div class="ui master checkbox">
                            <input type="checkbox" name="">
                            <label>Alle auswählen</label>
                        </div>
                    </div>
                    <div class="right aligned column">
                        <a class="ui tiny icon button" href="{{ route('portfolios.create') }}"
                           title="Ausgewählte Aufgabenbereiche bearbeiten." data-content="Aufgabenbereich hinzufügen">
                            <i class="plus icon"></i>
                        </a>
                        <button class="ui tiny icon button" type="submit" name="action" value="edit"
                                title="Ausgewählte Aufgabenbereiche bearbeiten." data-content="Bearbeiten">
                            <i class="edit icon"></i>
                        </button>
                        <button onclick="return confirm('Ausgewählte Aufgabenbereiche wirklich löschen?')"
                                class="ui tiny icon button" type="submit" name="action" value="delete"
                                title="Ausgewählte Aufgabenbereiche entfernen." data-content="Löschen">
                            <i class="trash icon"></i>
                        </button>
                        <button class="ui tiny icon button" type="submit" name="action" value="share"
                                title="Freigabecode für ausgewählte Aufgabenbereiche erzeugen."
                                data-content="Code generieren">
                            <i class="share icon"></i>
                        </button>
                        <div class="ui small input">
                            <input type="text" value="{{ $share ? $share->code : null }}" placeholder="Code">
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui divider dotted"></div>
            <div class="ui grid">
                <div class="row">
                    @forelse ($portfolios as $portfolio)
                        <div class="half wide column">
                            <div class="ui child checkbox">
                                <input id="portfolios[{{ $portfolio->id }}]" type="checkbox" class="checkable"
                                       name="portfolios[]"
                                       value="{{ $portfolio->id }}">
                                <label></label>
                            </div>
                        </div>
                        <div class="seven wide column">
                            <label class="small font" for="portfolios[{{ $portfolio->id }}]">
                                <div class="ui items">
                                    <div class="item">
                                        <div class="image">
                                            @if($portfolio->mediaInfos()->first())
                                                <img src="{{ $portfolio->mediaInfos()->first()->media->getImagePath('150x145') }}">
                                            @else
                                                <div class="placeholder-175-170"></div>
                                            @endif
                                        </div>
                                        <div class="content">
                                            <div class="header">{{ $portfolio->sort }}. {{ $portfolio->title }}</div>
                                            <div class="meta">{{ $portfolio->subtitle }}</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="half wide column"></div>
                        @if($loop->index % 2 == 1 && !$loop->last)
                            <div class="sixteen wide column">
                                <div class="ui hidden divider"></div>
                            </div>
                        @endif
                    @empty
                        <div class="cta-text">
                            <h2 class="green colored">Du hast noch keine Aufgabenbereiche.</h2>
                            <p>
                                Lege einen neuen Aufgabenbereich an oder klicke auf Hilfe um mehr über Aufgabenbereiche
                                zu erfahren.
                            </p>
                            <a class="ui primary button" href="{{ route('portfolios.create') }}">Aufgabenbereich
                                anlegen</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </form>
    </div>
    <div class="ui divider dotted"></div>
    @include('partials.content-header', [
        'title' => 'Aufgabenbereiche importieren',
        'divider' => false,
    ])
    <div class="ui middle aligned grid">
        <div class="row">
            <div class="column">
                Du kannst Aufgabenbereiche importieren, die von einer anderen Person erstellt wurden.<br>
                Gib dafür hier den Code ein.
            </div>
        </div>
        <div class="equal width row">
            <div class="column">
                Code
            </div>
            <div class="column">
                <div class="ui fluid input">
                    <input type="text" id="code" name="code" placeholder="Code eingeben">
                </div>
            </div>
        </div>
        <div class="equal width row">
            <div class="column"></div>
            <div class="column">
                <button onclick="window.share.preview()" class="ui primary button"
                        data-content="Aufgabenbereiche importieren">Importieren
                </button>
            </div>
        </div>
    </div>
    @include('partials.modal')
@endsection
