@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Neuen Aufgabenbereich erstellen',
        'divider' => false,
    ])
    <p>Erstelle hier einen neuen Aufgabenbereich</p>
    <div class="ui divider dotted"></div>
    <form method="POST" action="{{ route('portfolios.store') }}" class="ui form">
        @include('portfolios.partials.form', ['portfolio' => null])
    </form>
@endsection
