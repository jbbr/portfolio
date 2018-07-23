@include('partials.pagination', ['paginator' => $media])

@forelse($media as $_medium)
    @include('media.partials.item', [
        'mediaInfo' => $_medium->mediaInfos->where('user_id', Auth::id())->first()
    ])
@empty
    <div class="cta-text">
        <h2 class="green colored">Du hast noch keine Medien.</h2>
        <p>Lade neue Medien hoch oder klicke auf Hilfe um mehr über Medien zu erfahren.</p>
    </div>
@endforelse

@include('partials.pagination', ['paginator' => $media])
