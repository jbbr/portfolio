@extends('layouts.app')

@section('body-class', 'ep media')
@section('title', 'Mediathek')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => 'Mediathek',
        'divider' => false,
        'help' => Config::get('help.media'),
    ])
    <p>
        Hier kannst Du Dateien und Bilder hinzufügen und bearbeiten.
    </p>
    <div class="ui divider dotted"></div>
    <div class="ep ui grid">
        <div class="row">
            <div class="sixteen wide column" data-content="Medien zum Hochladen hinzufügen">
                <form action="{{ route('media.store') }}" class="dropzone" id="media-fileupload" method="post" enctype="multipart/form-data"></form>
            </div>
        </div>

        <div class="row">
            <div class="sixteen wide column">
                <button class="ui primary button" id="media-fileupload-button">{{ trans('Medien hochladen') }}</button>
            </div>
        </div>

        <div class="row">
            <div class="sixteen wide column">
                <div class="ui divided items" id="media-list">
                    @include('media.partials.list')
                </div>
            </div>
        </div>
    </div>

    @include('partials.modal')
    @include('partials.dropzone')
@endsection
