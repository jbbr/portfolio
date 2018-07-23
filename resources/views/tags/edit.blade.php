@extends('layouts.app')

@section('title', 'Tags')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $tag->name
    ])

    <form method="POST" action="{{ route('tags.update', $tag->id) }}" class="ui form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="put">
        <div class="fields">
            <div class="four wide field">
                <input type="text" name="name" value="{{ $tag->name }}">
            </div>
            <div class="two wide field">
                <button type="submit" class="ui primary button">Speichern</button>
            </div>
        </div>
    </form>
@endsection
