@extends('layouts.app')

@section('title', 'Öffentliche Freigaben')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Öffentliche Freigaben',
        'divider' => false,
    ])
    <p>Übersicht Deiner Freigaben</p>
    <div class="ui divider dotted"></div>
    @include('profile.partials.tabs')

    <div class="ui grid">
        <div class="ten wide column">
            <h2 class="green colored">Neue Freigabe</h2>
            <form method="POST" action="{{ route('publish.profile.save') }}" class="ui form publish-form">
                {{ csrf_field() }}
                {{ method_field('POST') }}

                <div class="ui middle aligned grid">
                    <div class="row">
                        <div class="four wide column">
                            <label for="title">Titel</label>
                        </div>
                        <div class="twelve wide column">
                            <input type="text" id="title" name="title" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="four wide column">
                            <label for="subtitle">Untertitel</label>
                        </div>
                        <div class="twelve wide column">
                            <input type="text" id="subtitle" name="subtitle" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="four wide column">
                            <label>Aufgabenbereiche</label>
                        </div>
                        <div class="twelve wide column">
                            <div class="ui fluid vertical accordion menu">
                                @foreach($portfolios as $portfolio)
                                    <div class="item checklist">
                                        <div class="title">
                                            <div class="ui middle aligned grid">
                                                <div class="row">
                                                    <div class="one wide column">
                                                        <div class="ui master checkbox stop-propagate">
                                                            <input type="checkbox"
                                                                   name="portfolio[{{ $portfolio->id }}]"
                                                                   data-id="{{ $portfolio->id }}">
                                                            <label></label>
                                                        </div>
                                                    </div>
                                                    <div class="fourteen wide column">
                                                        {{ $portfolio->sort }}. {{ $portfolio->title }}
                                                        @if ($portfolio->subtitle)
                                                            - {{ $portfolio->subtitle }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            @if($portfolio->entries()->count())
                                                <div class="grouped fields">
                                                    @foreach($portfolio->entries()->get() as $entry)
                                                        <div class="field">
                                                            <div class="ui middle aligned grid">
                                                                <div class="row">
                                                                    <div class="one wide column"></div>
                                                                    <div class="two wide column">
                                                                        <div class="ui child checkbox">
                                                                            <input type="checkbox"
                                                                                   name="entries[{{ $entry->id }}]"
                                                                                   data-portfolio="{{ $portfolio->id }}"
                                                                                   data-id="{{ $entry->id }}">
                                                                            <label> </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="thirteen wide column">
                                                                        @if($entry->mediaInfos->first())
                                                                            <img class="ui mini right spaced image"
                                                                                 src="{{ $entry->mediaInfos->first()->media->getImagePath() }}">
                                                                        @endif
                                                                        {{ $entry->title }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="four wide column"></div>
                        <div class="twelve wide column">
                            <button type="submit" class="ui primary button">Neue Freigabe erzeugen</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="six wide column">
            <h2 class="green colored">Freigaben</h2>
            <div class="ui divided items">
                @foreach($publishes as $publish)
                    <div class="item">
                        <div class="content">
                            <div class="header">
                                @if ($publish->created_at->addDays(1) > \Carbon\Carbon::now())
                                    {{ $publish->title }}
                                @else
                                    <del>{{ $publish->title }}</del>
                                    <div class="ui mini label" style="vertical-align: text-bottom">abgelaufen</div>
                                @endif
                            </div>
                            <div class="meta">{{ $publish->subtitle }}</div>
                            <div class="extra">
                                <form action="{{ route('publish.profile.delete', $publish->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    @if ($publish->created_at->addDays(1) > \Carbon\Carbon::now())
                                        <a href="{{ route('publish.portfolios.list', $publish->url) }}" target="_blank">Anzeigen</a>
                                        <a>|</a>
                                    @endif
                                    <a href="javascript:void(0)"
                                       onclick="confirm('Freigabe wirklich löschen?') ? parentNode.submit() : void(0)">Löschen</a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (!$publishes->count())
                    Du hast noch keine Freigaben erstellt.
                @endif
            </div>
        </div>
    </div>
@endsection
