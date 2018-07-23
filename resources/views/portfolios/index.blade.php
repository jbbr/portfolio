@extends('layouts.app')

@section('title', 'Portfolio')

@section('body-class', 'ep portfolios')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => 'Portfolio',
        'divider' => false,
        'edit' => route('portfolios.arrange'),
        'edittext' => 'Aufgabenbereiche hinzufügen und bearbeiten',
        'help' => Config::get('help.dashboard'),
    ])
    <p>Deine Aufgabenbereiche im Überblick.</p>
    <div class="ui divider dotted"></div>
    <div class="ep ui three columns grid filterable">
        <div class="row">
            @forelse($portfolios as $portfolio)
                @include('portfolios.partials.portfolio')
                @if ($loop->index % 3 == 2)
                    <div class="sixteen wide column">
                        <div class="ui divider dotted"></div>
                    </div>
                @endif
            @empty
                <div class="cta-text">
                    <h2 class="green colored">Du hast noch keine Aufgabenbereiche.</h2>
                    <p>Lege einen neuen Aufgabenbereich an oder klicke auf Hilfe um mehr über Aufgabenbereiche zu
                        erfahren.</p>
                    <a class="ui primary button" href="{{ route('portfolios.create') }}">Aufgabenbereich anlegen</a>
                </div>
            @endforelse
        </div>
    </div>

    @include('partials.modal')
@endsection
