@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => $entry->title
    ])

    <form method="POST" action="{{ route('portfolios.entries.update', [$portfolio->id, $entry->id]) }}" class="ui form" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        @include('entries.partials.form', ['entry' => $entry])
    </form>

    @include('partials.dropzone')
@endsection