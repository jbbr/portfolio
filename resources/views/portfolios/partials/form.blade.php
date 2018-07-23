{{ csrf_field() }}
<div class="ui middle aligned equal width grid">
    <div class="row">
        <div class="column">
            <label for="title">Titel</label>
        </div>
        <div class="column">
            <input type="text" id="title" name="title" required
                   placeholder="Titel des Aufgabenbereichs als Substantiv, z.B. Tierhalter"
                   value="{{ $portfolio ? $portfolio->title : old('title') }}">
        </div>
    </div>
    <div class="row">
        <div class="column">
            <label for="title">Untertitel</label>
        </div>
        <div class="column">
            <input type="text" id="subtitle" name="subtitle"
                   placeholder="Untertitel des Aufgabenbereichs als Verb(en), z.B. beraten und betreuen"
                   value="{{ $portfolio ? $portfolio->subtitle : old('subtitle') }}">
        </div>
    </div>
    <div class="row">
        <div class="column">
            <label for="description">Beschreibung</label>
        </div>
        <div class="column">
            <textarea name="description" class="tinymce"
                      placeholder="Beschreibung des Aufgabenbereichs, z.B. typische Kunden- und Arbeitsaufträge, korrespondierende Lernfelder und Berufsbildpositionen, Werkzeuge und Arbeitsgegenstände, Inhalte">
                {{ $portfolio ? $portfolio->description: old('description') }}
            </textarea>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <label for="tags">Schlagwörter</label>
        </div>
        <div class="column">
            <div id="tags" class="ui fluid multiple search selection dropdown" onkeypress="return event.keyCode != 13;">
                <input name="tags" type="hidden"
                       value="{{ $portfolio ? implode(',', $portfolio->tags->pluck('name')->toArray()) : old('tags') }}">
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
        <div class="column">
            <label for="media">Titelbild</label>
        </div>
        <div class="column">
            <div id="media" class="ui fluid search selection dropdown"
                 onkeypress="return event.keyCode != 13;">
                <input name="media" type="hidden"
                       value="{{ $portfolio ? implode(',', $portfolio->mediaLinks()->pluck('media_info_id')->toArray()) : old('media') }}">
                <i class="dropdown icon"></i>
                <div class="default text">Medien hinzufügen</div>
                <div class="menu">
                    <div class="item" data-value="">Medien hinzufügen</div>
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
        <div class="column">
            <label for="sort">Nummerierung der Aufgabenbereiche</label>
        </div>
        <div class="column">
            <input type="text" id="sort" name="sort" value="{{ old('sort', 0) }}">
        </div>
    </div>

    <div class="row">
        <div class="column"></div>
        <div class="column">
            <button type="submit" class="ui primary button">Speichern</button>
            <a href="{{ route('portfolios.arrange') }}" class="ui secondary button">Abbrechen</a>
        </div>
    </div>
</div>
