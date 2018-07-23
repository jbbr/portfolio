@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Neuen Eintrag erstellen',
        'divider' => false,
        'help' => Config::get('help.entry.create'),
    ])
    <p>Erstelle hier einen neuen Portfolio-Eintrag</p>
    <div class="ui divider dotted"></div>
    <form method="POST" action="{{ route('portfolios.entries.store', $portfolio->id) }}" class="ui form">
        @include('entries.partials.form', ['entry' => null])
    </form>

    @include('partials.dropzone')
@endsection
