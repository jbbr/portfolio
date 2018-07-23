<div class="media">
    @if( is_array( $media['integrate'] ) && array_key_exists( $_entry->id, $media['integrate'] ) )
        <div class="integrate">
            @foreach( $media['integrate'][ $_entry->id ] as $_integrate )
                <div class="container">

                    @if($_integrate->media->isMultimedia())
                        <?php $asset = "data:image/png;base64,".base64_encode(QrCode::format('png')->size(200)->encoding('UTF-8')->generate(asset($_integrate->media->getRealPath()))); ?>
                    @else
                        <?php $asset = asset($_integrate->media->getImagePath('285x180')); ?>
                    @endif

                    <div class="image"
                         style="background-image: url({{ $asset }});"></div>
                    <div class="desc">{{ $_integrate->media->filename }}</div>
                </div>
                @break(!$loop->first && $loop->index === 1)
            @endforeach
        </div>
        <div class="clearer"></div>
    @endif
</div>
