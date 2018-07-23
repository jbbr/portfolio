{{ csrf_field() }}
<div class="ui middle aligned equal width grid">
    <div class="row">
        <div class="four wide column">
            <label for="title">Titel</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="title" name="title" placeholder="Gib Deinem Eintrag einen treffenden Titel." required autofocus
                   value="{{ $entry ? $entry->title : old('title') }}">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="description">Beschreibung der Tätigkeit</label>
        </div>
        <div class="eight wide column">
                    <textarea id="description" name="description" class="tinymce"
                              placeholder="Beschreibe hier, welche Tätigkeit(en) Du in Berufsschule und Betrieb ausgeführt hast, oder was Du gerne in Deinem Portfolio dokumentieren möchtest.">{{ $entry ? $entry->description : old('description') }}</textarea>
            {{--<div class="word-counter-positioner">--}}
                {{--Anzahl Wörter:&nbsp;<span class="description-word-counter"></span>--}}
                <input type="hidden" value="0" name="wordcount" id="wordcount">
            {{--</div>--}}
        </div>

    </div>
    <div class="row">
        <div class="four wide column">
            <label for="location_id">Lernort</label>
        </div>
        <div class="eight wide column">
            <select id="location_id" name="location_id">
                <option value="">Lernort auswählen</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ $entry && $entry->location && $location->id === $entry->location->id ? 'selected' : null }}>{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row calendar-group">
        <div class="four wide column">
            <label for="date">Datum</label>
        </div>
        <div class="three wide column">
            <div class="ui calendar date-from" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="date" name="date" placeholder="22.03.2017" required autocomplete="off"
                           value="{{ $entry ? $entry->date : old('date') }}">
                </div>
            </div>
        </div>
        <div class="two wide center aligned column">
            bis
        </div>
        <div class="three wide column">
            <div class="ui calendar date-to" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="date_to" name="date_to" placeholder="25.03.2017" autocomplete="off"
                           value="{{ $entry ? $entry->date_to : old('date_to') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="duration">Dauer der Tätigkeit(en) in Std.</label>
        </div>
        <div class="three wide column">
            <div class="ui selection dropdown fluid duration">
                <input type="hidden" name="duration">
                <i class="dropdown icon"></i>
                @if($entry && $entry->duration)
                    <div class="text">{{ sprintf('%d:%02d', ($entry->duration/3600),($entry->duration/60%60)) }}</div>
                @else
                    <div class="text default">{{ old('duration') ?: '0:00' }}</div>
                @endif
                <div class="menu">
                    @for($secs = 0; $secs <= 43200; $secs += 300)
                        <div class="item {{ $entry && $secs == $entry->duration ? 'active selected' : null }}"
                             data-value="{{ $secs }}">{{ sprintf('%d:%02d', ($secs/3600),($secs/60%60)) }}</div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="tags">Schlagwörter</label>
        </div>
        <div class="eight wide column">
            <div id="tags" class="ui fluid multiple search selection dropdown" onkeypress="return event.keyCode != 13;">
                <input name="tags" type="hidden"
                       value="{{ $entry ? implode(',', $entry->tags->pluck('name')->toArray()) : old('tags') }}">
                <i class="dropdown icon"></i>
                <div class="default text">Schlagwörter hinzufügen</div>
                <div class="menu">
                    @foreach($tags as $tag)
                        <div class="item" data-value="{{ $tag->name }}">{{ $tag->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="media">Medien</label>
        </div>
        <div class="eight wide column">
            <div id="media" class="ui fluid multiple search selection dropdown no-addition"
                 onkeypress="return event.keyCode != 13;">
                <input name="media" type="hidden"
                       value="{{ $entry ? implode(',', $entry->mediaInfos()->pluck('media_info_id')->toArray()) : old('media') }}">
                <i class="dropdown icon"></i>
                <div class="default text">Medien hinzufügen</div>
                <div class="menu">
                    @foreach($mediaInfos as $mediaInfo)
                        <div class="item" data-value="{{ $mediaInfo->id }}">
                            @if ($mediaInfo->media->isVideo())
                                <img src="{{$mediaInfo->media->getImagePath('video_thumbnails')}}"/>
                            @elseif ($mediaInfo->media->isAudio())
                                <img src="{{$mediaInfo->media->defaultMimeTypeImage()}}"/>
                            @else
                                <img src="{{$mediaInfo->media->getImagePath('150x145')}}"/>
                            @endif
                            {{ $mediaInfo->media->filename }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="four wide column">
            <label for="media">Neue Medien</label>
        </div>
        <div class="eight wide column">
            <div class="dropzone" id="entries-media-upload" data-url="{{ route('portfolios.entries.upload', ['portfolio' => $portfolio->id])  }}"></div>
            <input type="hidden" name="processedMediaFiles" id="processed-media-files" value="">
        </div>
    </div>



    <div class="row">
        <div class="four wide column">
            <label for="portfolio_id">Aufgabenbereich</label>
        </div>
        <div class="eight wide column">
            <select id="portfolio_id" name="portfolio_id" required>
                @foreach($portfolios as $pf)
                    <option value="{{ $pf->id }}" {!! $pf->id == $portfolio->id ? 'selected="selected" class="original"' : null !!}>{{ $pf->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="four wide column"></div>
        <div class="eight wide column">
            <button id="button_save" type="submit" class="ui primary button">Speichern</button>
            <button id="button_copy" type="submit" class="ui primary button" style="display: none;">In Aufgabenbereich kopieren</button>
            <a href="{{ route('portfolios.entries.index', $portfolio->id) }}" class="ui secondary button">Abbrechen</a>
        </div>
    </div>
</div>
