<div class="topnavigation">
    @if (Auth::check())
        <?php
            $userImg = Auth::user()->getPicturePath();
            if(is_null($userImg)) {
                $userImg = asset('images/user.png');
            }
        ?>
        <div class="item">
            <a href="{{ route('profile.index') }}"><img src="{{$userImg}}" style="max-width: 45px; max-height: 45px; border-radius: 500rem;"></a>
            <a href="{{ route('profile.index') }}" class="small ui secondary button" data-content="Profil">{{ Auth::user()->name }}</a>
        </div>
    @endif
    <div class="item">
        <a href="{{ Config::get('help.support') }}" style="display: block; margin-bottom: 10px"><i class="circular inverted info secondary large icon"></i></a>
        <a href="{{ Config::get('help.support') }}" target="_blank" class="small ui secondary button" data-content="Hilfe/FAQ">Hilfe/FAQ</a>
    </div>
    <div class="item">
        @if (Auth::guest())
            <a href="{{ route('login') }}" style="display: block; margin-bottom: 10px"><i class="circular inverted power off primary large icon"></i></a>
            <a href="{{ route('login') }}" class="small ui primary button" data-content="Anmelden">Anmelden</a>
        @else
            <form action="{{ route('logout') }}" method="POST">
                <a href="javascript:void(0)" onclick="event.target.parentElement.submit()" style="display: block; margin-bottom: 10px"><i class="circular inverted power off primary large icon"></i></a>
                {{ csrf_field() }}
                <button type="submit" class="small ui primary button" data-content="Abmelden">Abmelden</button>
            </form>
        @endif
    </div>
</div>
