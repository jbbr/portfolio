@extends('publish.layout')

@section('title', $publish->title ?: "Freigabe")

@section('body-class', 'ep portfolios')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $publish->title ?: "Freigabe",
        'subtitle' => $publish->subtitle ?: "",
        'divider' => true,
    ])

    <div class="ep ui three columns grid filterable">
        <div class="row">
            @foreach($portfolios as $portfolio)
                @include('publish.partials.portfolio')
                @if ($loop->index % 3 == 2)
                    <div class="sixteen wide column">
                        <div class="ui divider dotted"></div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    @include('partials.modal')
@endsection
