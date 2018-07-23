<div class="media">
    @if( is_array( $media['integrate'] ) && array_key_exists( $_entry->id, $media['integrate'] ) )
        <div class="integrate">
            <div class="title">Medien</div>
            @foreach( $media['integrate'][ $_entry->id ] as $_integrate )
                <div class="container">
                    @if($_integrate->media->isMultimedia())
                        <img class="image" src="{{ asset( $_integrate->media->getQrCode() ) }}">
                    @else
                        <img class="image" src="{{ asset( $_integrate->media->getImagePath('original') ) }}">
                    @endif
                    <div class="desc">{{ $_integrate->media->filename }}</div>
                </div>
                @break(!$loop->first && $loop->index === 1)
            @endforeach
        </div>
        <div class="clearer"></div>
    @endif

    @if( is_array( $media['attach'] ) && array_key_exists( $_entry->id, $media['attach'] ) )
        <div class="attachment">
            <div class="title">Anhang:</div>
            @foreach( $media['attach'][ $_entry->id ] as $_attach )
                <div class="item">{{ $_attach->media->filename }}</div>
            @endforeach
        </div>
    @endif
</div>
