@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', ['title' => $location->name])
    <form method="POST" action="{{ route('locations.update', $location->id) }}" class="ui form">
        <input type="hidden" name="_method" value="put">
        @include('locations.partials.form')
    </form>
@endsection
