@extends('publish.layout')

@section('title', $publish->title ?: "Freigabe")

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $publish->title ?: "Freigabe",
        'subtitle' => $publish->subtitle ?: "",
        'divider' => true,
        'backurltxt' => 'Zurück',
        'backurl' => route('publish.entries.list', [$urlkey, $portfolioId])
    ])

    <h2>{{ $entry->title }}</h2>
    <div class="slider">
        @foreach($entry->mediaInfos as $mediaInfo)
            <div>
                <img src="{{ $mediaInfo->media->getImagePath('1047x300') }}">
            </div>
        @endforeach
    </div>
    <div class="ui grid divided">
        <div class="ten wide column">
            <p>{!! $entry->description !!}</p>
        </div>
        <div class="six wide column">
            <b>Datum:</b> {{ $entry->date }}
            @if($entry->date_to)
                bis {{ $entry->date_to }}
            @endif
            <br/>
            @if($entry->duration)
                <b>Dauer:</b> {{ sprintf('%d:%02d', $entry->duration/3600, $entry->duration/60%60) }} Std.<br/>
            @endif
            @if($entry->location)
                <b>Lernort:</b> {{ $entry->location->name }}<br/>
            @endif
            <br/>
            <br/>
            <b>Schlagwörter:</b><br/>
            @foreach($entry->tags as $tag)
                <a href="{{ route('tags.show', ['tag' => $tag->id ]) }}">
                    <div class="ui label">
                        {{ $tag->name }}
                    </div>
                </a>
            @endforeach
            <br/>
            <br/>
            <b>Medien:</b><br/>
            @foreach($entry->mediaInfos as $mediaInfo)
                <div id="item-{{$mediaInfo->media->id}}">
                    <div class="entry image" data-content="{{$mediaInfo->media->filename}}" onclick="media.preview({{$mediaInfo->media->id}})">
                        <img src="{{$mediaInfo->media->getImagePath()}}" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('partials.modal')
@endsection
