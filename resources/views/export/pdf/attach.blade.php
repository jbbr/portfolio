@if(!empty($media['attach']))
    <div class="page-break"></div>

    <div class="attachment-overview">
        <div class="title">Anhänge:</div>
        @if( $type == "explicit" )
            <div class="hr"></div>
        @else
            <div class="hr green"></div>
        @endif

        @foreach($media['attach'] as $_entryId => $_attachments)
            @foreach($_attachments as $_attachment)
                <div class="attachment">{{ $_attachment->media->filename }}</div>
            @endforeach
        @endforeach
    </div>
@endif
