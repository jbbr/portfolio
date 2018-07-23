<div class="row">
    <div class="four wide column">
        <label for="portfolios[{{ $portfolio->id }}][title]">Titel</label>
    </div>
    <div class="eight wide column">
        <input type="text" required id="portfolios[{{ $portfolio->id }}][title]" name="portfolios[{{ $portfolio->id }}][title]"
               value="{{ $portfolio->title }}">
    </div>
</div>
<div class="row">
    <div class="four wide column">
        <label for="portfolios[{{ $portfolio->id }}][subtitle]">Untertitel</label>
    </div>
    <div class="eight wide column">
        <input type="text" id="portfolios[{{ $portfolio->id }}][subtitle]" name="portfolios[{{ $portfolio->id }}][subtitle]"
               value="{{ $portfolio->subtitle }}">
    </div>
</div>
<div class="row">
    <div class="four wide column">
        <label for="portfolios[{{ $portfolio->id }}][description]">Beschreibung</label>
    </div>
    <div class="eight wide column">
        <textarea id="portfolios[{{ $portfolio->id }}][description]" name="portfolios[{{ $portfolio->id }}][description]" class="tinymce"
                  placeholder="Beschreibe hier, welche Tätigkeit(en) Du in Berufsschule und Betrieb ausgeführt hast, oder was Du gerne in Deinem Portfolio dokumentieren möchtest."
                  rows="3">{{ $portfolio ? $portfolio->description : old('description') }}</textarea>
    </div>
</div>
<div class="row">
    <div class="four wide column">
        <label for="portfolios[{{ $portfolio->id }}][tags]">Schlagwörter</label>
    </div>
    <div class="eight wide column">
        <div id="portfolios[{{ $portfolio->id }}][tags]" class="ui fluid multiple search selection dropdown"
             onkeypress="return event.keyCode != 13;">
            <input id="portfolios[{{ $portfolio->id }}][tags]" name="portfolios[{{ $portfolio->id }}][tags]" type="hidden"
                   value="{{ $portfolio ? implode(',', $portfolio->tags->pluck('name')->toArray()) : old('tags') }}">
            <i class="dropdown icon"></i>
            <div class="default text">Hinzufügen</div>
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
        <label for="portfolios[{{ $portfolio->id }}][media]">Titelbild</label>
    </div>
    <div class="eight wide column">
        <div id="portfolios[{{ $portfolio->id }}][media]" class="ui fluid search selection dropdown"
             onkeypress="return event.keyCode != 13;">
            <input name="portfolios[{{ $portfolio->id }}][media]" type="hidden"
                   value="{{ $portfolio ? implode(',', $portfolio->mediaLinks()->pluck('media_info_id')->toArray()) : old('media') }}">
            <i class="dropdown icon"></i>
            <div class="default text">Hinzufügen</div>
            <div class="menu">
                <div class="item" data-value="">Kein Bild</div>
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
        <label for="portfolios[{{ $portfolio->id }}][sort]">Nummerierung der Aufgabenbereiche</label>
    </div>
    <div class="eight wide column">
        <input type="text" id="portfolios[{{ $portfolio->id }}][sort]" name="portfolios[{{ $portfolio->id }}][sort]"
               value="{{ $portfolio->sort }}">
    </div>
</div>
