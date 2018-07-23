<div class="item">
    <div class="ui child checkbox">
        <input id="entry[{{ $entry->id }}]" type="checkbox" class="checkable"
               name="entries[]"
               value="{{ $entry->id }}" checked="checked">
        <label></label>
    </div>
    <div class="slider-container small">
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
                    <img class="ui small image" data-content="{{$mediaInfo->media->filename}}" src="{{ $src }}" onclick="media.preview({{$mediaInfo->media->id}})"/>

                </div>
            @endforeach
        </div>
    </div>

    <div class="content">
        <div class="sixteen wide column">
            <h2 class="green colored">{{ $entry->title }}</h2>
        </div>
        <div class="sixteen wide column">
            Aufgabenbereich: {{ $entry->portfolio->sort }}. {{ $entry->portfolio->title }}
        </div>
        <div class="sixteen wide column">
            Datum: {{ $entry->date }}
        </div>
        @if($entry->location)
            <div class="sixteen wide column">
                Lernort: {{ $entry->location->name }}
            </div>
        @endif

        @if($entry->tags)
            <div class="sixteen wide column">
                @foreach($entry->tags as $tag)
                    <div class="ui label" data-value="{{ $tag->name }}">{{ $tag->name }}</div>
                @endforeach
            </div>
        @endif
    </div>

    @if($entry->mediaInfos->count() > 0)
        <div class="media-selection">
            <a class="browse item" data-entry="{{ $entry->id }}">
                Medienauswahl für Ausgabe
                <i class="dropdown icon"></i>
            </a>
        </div>

        <div class="ui popup top left transition hidden entry-media-{{ $entry->id }}" data-entry-id="{{ $entry->id }}">
            <div class="ui grid" style="width: 550px;">
                <div class="column">
                    <div class="ui link list">
                        <a class="item">
                            <div class="ui form">
                                <div class="grouped fields">
                                    <table class="ui fixed single line very basic table">
                                        <thead>
                                        <tr>
                                            <th class="nine wide">Medium in Ausgabe</th>
                                            <th class="nine wide">Medium in Anhang</th>
                                            <th class="twelve wide">Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($entry->mediaInfos as $mediaInfo )
                                            <tr>
                                                <td>
                                                    <div class="ui checkbox">
                                                        <input type="checkbox" name="integrate[{{ $entry->id }}][]" value="{{ $mediaInfo->id }}"
                                                               @if($loop->index<2)checked="checked"@endif>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="ui checkbox">
                                                        <input type="checkbox" name="attach[{{ $entry->id }}][]" value="{{ $mediaInfo->id }}"
                                                               @if($loop->index>1)checked="checked"@endif>
                                                        <label></label>
                                                    </div>
                                                </td>
                                                <td class="pt-0 pb-0">
                                                    @if ($mediaInfo->media->isVideo())
                                                        <img class="ui mini spaced image" src="{{$mediaInfo->media->getImagePath('video_thumbnails')}}"
                                                             onclick="media.preview({{$mediaInfo->media->id}})"/>
                                                    @elseif ($mediaInfo->media->isAudio())
                                                        <img class="ui mini spaced image" src="{{$mediaInfo->media->defaultMimeTypeImage()}}"
                                                             onclick="media.preview({{$mediaInfo->media->id}})"/>
                                                    @else
                                                        <img class="ui mini spaced image" src="{{$mediaInfo->media->getImagePath('150x145')}}"
                                                             onclick="media.preview({{$mediaInfo->media->id}})"/>
                                                    @endif
                                                    {{ $mediaInfo->media->filename }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
