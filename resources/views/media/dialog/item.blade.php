<div class="item" id="item-{{ $_medium->id }}">
    <div class="ui small image pointer">
        @if ($_medium->isVideo())
            <img src="{{ $_medium->getImagePath('video_thumbnails') }}">
            <?php $path = $_medium->getImagePath('video_thumbnails'); ?>
        @elseif ($_medium->isAudio())
            <img src="{{ $_medium->defaultMimeTypeImage() }}">
            <?php $path = $_medium->getQrCode(); ?>
        @else
            <img src="{{ $_medium->getImagePath('150x145') }}">
            <?php $path = $_medium->getImagePath('original'); ?>
        @endif
    </div>
    <div class="content">
        <div class="header">{{ $_medium->filename }}</div>

        <div class="actions">
            <button class="ui icon right floated primary button media-insert-btn" data-path="{{ $path }}" data-content="Einfügen"><i class="paste icon"></i>
            </button>
        </div>

        <div class="meta">
            <div class="ui ep grid">
                <div class="twelve wide column">
                    <b>Beschreibung:</b> {{ $mediaInfo->description }}
                </div>
                <div class="six wide column">
                    <b>Datum:</b> {{ \Carbon\Carbon::parse($mediaInfo->created_at)->format('d.m.Y H:i') }}
                </div>
                <div class="six wide column">
                    <b>Typ:</b> {{ $_medium->mime_type }}
                </div>
                <div class="six wide column">
                    <b>Größe:</b> {{ $_medium->size }}
                </div>
                <div class="six wide column">
                    <b>Autor:</b> {{ $mediaInfo->author }}
                </div>
                <div class="six wide column">
                    <b>Ort der Erstellung:</b> {{ $mediaInfo->place_of_creation}}
                </div>
                <div class="six wide column">
                    <b>Lizenz:</b> {{ $mediaInfo->license }}
                </div>
                <div class="twelve wide column">
                    <b>Urheberrecht:</b> {{ $mediaInfo->copyright }}
                </div>
                @if( $mediaInfo->tags()->count() > 0 )
                    <div class="sixteen wide column">
                        @foreach($mediaInfo->tags as $tag)
                            <a href="{{ route('tags.show', $tag->id) }}" class="ui label">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
