<div class="profile second">
    <div class="logo"><img style="height: 150px; width: auto;" src="{{ url((new \App\Config())->getConfigPictureUrl('system_logo', asset('images/logo.png')))}}"></div>
    <div class="sub_title">Berichtsheft (Ausbildungsnachweis)</div>
    <div class="informations">
        <div class="block">Auszubildende/r:  {{ Auth::user()->name }}</div>
        <div class="block">Ausbildende/r:</div>
        <div class="block"><input type="checkbox" /><div class="padding-l-25">Quartalsberichte, Anzahl: {{ $part['c2'] }}</div></div>
        <div class="block padding-b-25"><input type="checkbox" /><div class="padding-l-25">Schwerpunktthema, Anzahl: {{ $part['c1'] }}</div></div>

        <div class="block">
            Bemerkungen:  ___________________________________________________________________________________
            ___________________________________________________________________________________________________
            ___________________________________________________________________________________________________
        </div>
        <div class="block">
            ( ) Ihr Berichtsheft ist ordnungsgemäß geführt: _________________________________________________
            ___________________________________________________________________________________________________
            ___________________________________________________________________________________________________
        </div>
        <div class="block">
            ( ) Ihr Berichtsheft ist unvollständig und folgendes muss nachgereicht werden: _______________
            ___________________________________________________________________________________________________
            ___________________________________________________________________________________________________
        </div>

        <div class="date">
            _____________________________________________<br />
            Datum
        </div>

        <div class="sign">
            _____________________________________________<br />
            Name, Unterschrift<br />
            <span class="sub">(Mitglied Prüfungsausschuss)</span>
        </div>

        <div class="clearer"></div>

        <div class="attention">
            Achtung!<br />
            Bitte diesen Korrekturbogen unbedingt an dieser Stelle im Berichtsheft belassen.
        </div>

    </div>

</div>
