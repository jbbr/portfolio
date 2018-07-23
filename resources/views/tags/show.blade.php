@extends('layouts.app')

@section('title', 'Tags')

@section('content')
    @include('partials.flash')

    @include('partials.content-header', [
        'title' => $tag->name,
        'delete' => [
            'route' => route('tags.destroy', [$tag->id]),
            'confirm' => 'Schlagwort wirklich löschen?'
        ],
        'edit' => route('tags.edit', [$tag->id])
    ])

    <div class="ui secondary menu">
        <a class="item active" data-tab="entries">Einträge</a>
        <a class="item" data-tab="portfolios">Aufgabenbereiche</a>
        <a class="item" data-tab="media">Medien</a>
    </div>
    <div class="ui tab active" data-tab="entries">
        @foreach($tag->entries as $entry)
            <div class="ui divider dotted"></div>
            <h3>
                <a href="{{ route('portfolios.entries.show', [$entry->portfolio->id, $entry->id]) }}">{{ $entry->title }}</a>
            </h3>
            <p>{!! $entry->description !!}</p>
            <div>
                @foreach($entry->tags as $entrytag)
                    <a href="{{ route('tags.show', $entrytag->id) }}" class="ui label">{{ $entrytag->name }}</a>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="ui tab" data-tab="portfolios">
        @foreach($tag->portfolios()->orderBy('sort', 'ASC')->get() as $portfolio)
            <div class="ui divider dotted"></div>
            <h3>
                <a href="{{ route('portfolios.entries.index', $portfolio->id) }}">{{ $portfolio->sort }}. {{ $portfolio->title }}</a>
            </h3>
            <p>{{ $portfolio->subtitle }}</p>
            <div>
                @foreach($portfolio->tags as $portfoliotag)
                    <a href="{{ route('tags.show', $portfoliotag->id) }}" class="ui label">{{ $portfoliotag->name }}</a>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="ui tab" data-tab="media">
        @foreach($tag->mediaInfos as $mediaInfo)
            <div class="ui divider dotted"></div>
            <div class="ui items">
                <div class="item">
                    <div class="ui small image">
                        @if ($mediaInfo->media->isVideo())
                            <img src="{{$mediaInfo->media->getImagePath('video_thumbnails')}}"/>
                        @elseif ($mediaInfo->media->isAudio())
                            <img src="{{$mediaInfo->media->defaultMimeTypeImage()}}"/>
                        @else
                            <img src="{{$mediaInfo->media->getImagePath()}}"/>
                        @endif
                    </div>
                    <div class="content">
                        <h3>
                            {{ $mediaInfo->media->filename }}
                        </h3>
                        <p>{{ $mediaInfo->description }}</p>
                        <div>
                            @foreach($mediaInfo->tags as $mediaInfoTag)
                                <a href="{{ route('tags.show', $mediaInfoTag->id) }}"
                                   class="ui label">{{ $mediaInfoTag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
