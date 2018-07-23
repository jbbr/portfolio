@extends('layouts.app')

@section('body-class', 'ep export')
@section('title', 'Ausgabe')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => 'Ausgabe',
        'subtitle' => 'Erstellen',
        'help' => Config::get('help.export')
    ])

    <form class="ui form" method="POST" action="{{ route('export.send') }}">
        {{ csrf_field() }}

        @include('export.partials.selection')

        <div class="ui divider dotted"></div>

        @include('export.partials.filter')

    @include('export.partials.list')

    </form>

    @include('partials.modal')

@endsection
