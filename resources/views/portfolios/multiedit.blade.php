@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Aufgabenbereiche'
    ])
    <form method="POST" action="{{ route('portfolios.multiupdate') }}" class="ui form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="put">
        <div class="ui equal width middle aligned grid">
            @foreach($portfolios as $portfolio)
                @include('portfolios.partials.multiform')
                @if(!$loop->last)
                    <div class="ui divider dotted"></div>
                @endif
            @endforeach
            <div class="row">
                <div class="four wide column"></div>
                <div class="eight wide column">
                    <button type="submit" class="ui primary button">Speichern</button>
                    <a href="{{ route('portfolios.arrange') }}" class="ui secondary button">Abbrechen</a>
                </div>
            </div>
        </div>
    </form>
@endsection
