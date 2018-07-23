@extends('publish.layout')

@section('title', $publish->title ?: "Freigabe")

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $publish->title ?: "Freigabe",
        'subtitle' => $publish->subtitle ?: "",
        'divider' => true,
        'backurltxt' => 'Zurück',
        'backurl' => route('publish.portfolios.list', [$urlkey])
    ])

    <div class="ep ui three columns grid filterable" style="margin-top: 0;">
        @if($entries->lastPage() > 1)
            <div class="row">
                <div class="column">
                    @include('partials.pagination', ['paginator' => $entries])
                </div>
            </div>
        @endif
        <div class="row">
            @foreach ($entries as $entry)
                @if ($loop->index % 3 == 0)
                    <div class="sixteen wide column">
                        <div class="ui divider dotted"></div>
                    </div>
                @endif
                @include('publish.entries.entry')
            @endforeach
        </div>
        @if($entries->lastPage() > 1)
            <div class="row">
                <div class="column">
                    @include('partials.pagination', ['paginator' => $entries])
                </div>
            </div>
        @endif
    </div>

    @include('partials.modal')
@endsection