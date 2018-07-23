@extends('layouts.app')
@section('title', 'Portfolio')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $portfolio->sort . '. ' . $portfolio->title,
        'backurl' => route('portfolios.entries.index', $portfolio->id),
        'subtitle' => $portfolio->subtitle,
        'delete' => [
            'route' => route('portfolios.entries.destroy', [$portfolio->id, $entry->id]),
            'confirm' => 'Eintrag wirklich löschen?'
        ],
        'edit' => route('portfolios.entries.edit', [$portfolio->id, $entry->id]),
        'help' => Config::get('help.entry.show'),
    ])

    <h2>{{ $entry->title }}</h2>
    <div class="slider">
        @foreach($entry->mediaInfos as $mediaInfo)
            @if(!$mediaInfo->media->isMultimedia())
                <div>
                    <img src="{{ $mediaInfo->media->getImagePath('1047x300') }}">
                </div>
            @endif
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
            <div class="slider-container">
                <div class="slider">
                    @foreach($entry->mediaInfos as $mediaInfo)
                        <div>
                            @if ($mediaInfo->media->isVideo())
                                <?php $src = $mediaInfo->media->getImagePath('video_thumbnails'); ?>
                            @elseif ($mediaInfo->media->isAudio())
                                <?php $src = $mediaInfo->media->defaultMimeTypeImage(); ?>
                            @else
                                <?php $src = $mediaInfo->media->getImagePath(); ?>
                            @endif

                            <img class="ui image" data-content="{{$mediaInfo->media->filename}}" src="{{ $src }}" onclick="media.preview({{$mediaInfo->media->id}})">

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('partials.modal')
@endsection
