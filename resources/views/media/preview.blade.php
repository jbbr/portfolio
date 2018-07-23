<div class="ui image">
    @if ($medium->isVideo())
        <video style="width: 100%" controls>
            <source src="{{ $medium->getRealPath() }}" type="video/mp4">
            Ihr Browser unterstützt keine HTML5 Videos.
        </video>
    @elseif ($medium->isAudio())
        <audio style="width: 100%" controls>
            <source src="{{ $medium->getRealPath() }}" type="audio/mpeg">
            Ihr Browser unterstützt keine HTML5 Videos.
        </audio>
    @else
        <img src="{{ $medium->getImagePath('original') }}" class="preview-image"/>
    @endif
</div>
