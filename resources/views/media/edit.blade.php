<form method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="ui form">

        <div class="field">
            <label>Name:</label>
            <input type="text" value="{{ $medium->filename }}" disabled="disabled"/>
        </div>

        <div class="field">
            <label>Beschreibung:</label>
            <textarea name="description" placeholder="">{{ $mediaInfo->description }}</textarea>
        </div>

        <div class="field">
            <label>Autor:</label>
            <input name="author" type="text" value="{{ $mediaInfo->author }}" />
        </div>

        <div class="field">
            <label>Ort der Erstellung:</label>
            <input name="place_of_creation" type="text" value="{{ $mediaInfo->place_of_creation }}" />
        </div>

        <div class="field">
            <label>Angabe zum Urheberrecht:</label>
            <input name="copyright" type="text" value="{{ $mediaInfo->copyright }}" />
        </div>

        <div class="field">
            <label>Lizenz:</label>
            <input name="license" type="text" value="{{ $mediaInfo->license }}" />
        </div>

        <div class="field">
            <label for="tags">Schlagwörter</label>
            <div id="tags" class="ui fluid multiple search selection dropdown" onkeypress="return event.keyCode != 13;">
                <input name="tags" type="hidden" value="{{ $mediaInfo ? implode(',', $mediaInfo->tags->pluck('name')->toArray()) : old('tags') }}">
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

    {{ Form::hidden('mediumid', $mediaInfo->media_id ) }}
</form>
