<div class="footer">
    <div class="footer-images">
        @foreach(range(1,5) as $_nr)
            <?php $currentImg = (new App\Config())->getConfigPictureUrl("system_footer_" . $_nr); ?>
            @if($currentImg)
                <div class="image-container">
                    <img class="ui small image" src="{{ $currentImg }}"/>
                </div>
            @endif
        @endforeach
    </div>
    <div class="footer-inner">
        <a href="{{ route('imprint') }}">Impressum</a> <a>|</a> <a href="{{ route('privacy') }}">Datenschutz</a>
    </div>
</div>
