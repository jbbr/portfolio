<div class="item" id="item-{{ $_medium->id }}">
    <div class="ui small image pointer">
        @if ($_medium->isVideo())
            <img src="{{ $_medium->getImagePath('video_thumbnails') }}" onclick="media.preview({{ $_medium->id }});">
        @elseif ($_medium->isAudio())
            <img src="{{ $_medium->defaultMimeTypeImage() }}" onclick="media.preview({{ $_medium->id }});">
        @else
            <img src="{{ $_medium->getImagePath('150x145') }}" onclick="media.preview({{ $_medium->id }});">
        @endif
    </div>
    <div class="content">
        <div class="header">{{ $_medium->filename }}</div>

        <div class="actions">

            <form method="POST" action="{{ route('media.destroy', $_medium->id) }}" onsubmit="return confirm('Medium wirklich löschen?')">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button type="submit" class="ui icon right floated secondary button" data-content="Löschen"><i class="trash icon"></i></button>
            </form>

            {{ Form::open([ 'method'  => 'get', 'route' => ['media.download', $_medium->id] ]) }}
            <button type="submit" class="ui icon right floated primary button media-download-btn" data-content="Herunterladen"><i class="download icon"></i></button>
            {{ Form::close() }}

            <button type="button" class="ui icon right floated primary button media-edit-btn" data-mediumid="{{ $_medium->id }}" data-content="Bearbeiten"><i class="edit icon"></i></button>
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

                @if( $mediaInfo->entries()->count() > 0 )
                    <div class="sixteen wide column">
                        <div class="ui accordion">
                            <div class="title">
                                <i class="dropdown icon"></i>
                                Verwendung ({{ $mediaInfo->entries()->count() }})
                            </div>
                            <div class="content">
                                <p class="transition hidden">
                                    <ul>
                                    @forelse( $mediaInfo->entries()->get() as $_entry )
                                        <li><a href="{{ route('portfolios.entries.show', [$_entry->portfolio_id, $_entry->id]) }}">{{ $_entry->title }}</a></li>
                                    @empty
                                        <li>Es sind keine Einträge vorhanden.</li>
                                    @endforelse
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
