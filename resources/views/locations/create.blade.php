@extends('layouts.app')

@section('title', 'Lernorte')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Neuen Lernort erstellen',
        'divider' => false,
        'addtext' => 'Lernort hinzufügen',
    ])
    <p>Lege hier einen neuen Lernort an.</p>
    <div class="ui divider dotted"></div>
    <form method="POST" action="{{ route('locations.store') }}" class="ui form">
        @include('locations.partials.form', ['location' => null])
    </form>
@endsection
