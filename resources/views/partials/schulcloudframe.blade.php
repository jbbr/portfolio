{{-- Show iframe from schulcloud if any --}}
<?php
$iframe = null;
if (Auth::check()) {
    $identity = Auth::user()
        ->oauthIdentities()
        ->where('provider', 'schulcloud')
        ->first();
    $iframe = $identity ? $identity->iframe : null;
}
?>
@if(!is_null($iframe))
    <div class="userframe ui right aligned container">
        {!! $iframe !!}
    </div>
@endif