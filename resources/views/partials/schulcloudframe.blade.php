{{-- Show iframe from schulcloud if any --}}
@auth
    @php
        $identity = Auth::user()
            ->oauthIdentities()
            ->where('provider', 'schulcloud')
            ->first();
        $iframe = $identity ? $identity->iframe : null;
    @endphp
    @if(!is_null($iframe))
        <div class="userframe ui right aligned container">
            {!! $iframe !!}
        </div>
    @endif
@endauth