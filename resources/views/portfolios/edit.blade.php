@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => $portfolio->title
    ])

    <form method="POST" action="{{ route('portfolios.update', $portfolio->id) }}" class="ui form">
        <input type="hidden" name="_method" value="put">
        @include('portfolios.partials.form')
    </form>
@endsection
