@extends('layouts.app')

@section('title', 'Lernorte')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => $location->name,
        'delete' => [
            'route' => route('locations.destroy', [$location->id]),
            'confirm' => 'Lernort wirklich löschen?',
        ],
        'edit' => route('locations.edit', [$location->id]),
    ])
    @include('locations.partials.details')
    @foreach($location->entries as $entry)
        <div class="ui divider dotted"></div>
        <h3>
            <a href="{{ route('portfolios.entries.show', [$entry->portfolio->id, $entry->id]) }}">{{ $entry->title }}</a>
        </h3>
        <p>{{ $entry->description }}</p>
    @endforeach
@endsection
