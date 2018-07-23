@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $portfolio->sort . '. ' . $portfolio->title,
        'subtitle' => $portfolio->subtitle,
        'divider' => false,
        'help' => Config::get('help.entry.list'),
    ])
    <p>Übersicht Deiner Einträge in diesem Aufgabenbereich.</p>
    <div class="ui divider dotted"></div>

    @include('entries.partials.filter')
    <div class="ep ui three columns grid filterable">
        <div class="row">
            <div class="column">
                @include('partials.custom_pagination', ['paginator' => $customPagination])
            </div>
        </div>
        <div class="row">
            @if($customPagination->current_page == 1)
                @include('entries.partials.entrycreate')
            @endif
            @foreach ($entries as $entry)
                @if ((($loop->index == 2 || $loop->index > 2) && $customPagination->current_page == 1) && $loop->index % 3 == 2)
                    <div class="sixteen wide column">
                        <div class="ui divider dotted"></div>
                    </div>
                @endif
                @include('entries.partials.entry')
            @endforeach
        </div>
        <div class="row">
            <div class="column">
                @include('partials.custom_pagination', ['paginator' => $customPagination])
            </div>
        </div>
    </div>
@endsection
