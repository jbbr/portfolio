{{--
This templates embeds an iFrame provided by the Schul-Cloud OAuth Integration.
The iFrame provides information about the associated Schul-Cloud user without breaking pseudonymization.

Required JS is bundled in this template to prevent it from cluttering core js files.
This template is only rendered if Schul-Cloud OAuth provider is enabled.
--}}
@auth
    @php
        $identity = Auth::user()
            ->oauthIdentities()
            ->where('provider', 'schulcloud')
            ->first();
        $iframe = $identity ? $identity->iframe : null;
    @endphp
    @if(!is_null($iframe))
        <div id="userframe" class="userframe ui right aligned container" style="display: none">
            {!! $iframe !!}
        </div>
        <script defer>
            {{-- display Schul-Cloud iFrame if page is not embedded in iframe --}}
            (function () {
                var isDisplayedInFrame = window.top !== window.self;
                if (isDisplayedInFrame) {
                    return;
                }
                var frameContainer = document.getElementById('userframe');
                if (frameContainer) {
                    frameContainer.style.display = 'block';
                }
            })();
        </script>
    @endif
@endauth