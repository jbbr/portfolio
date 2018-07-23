<div class="profile second">
    <div class="logo"><img src="{{(new \App\Config())->getConfigPictureUrl('system_logo', asset('images/logo.png'))}}"/></div>
    <div class="sub_title">Berichtsheft (Ausbildungsnachweis)</div>
    <div class="informations">
        <div class="block">Auszubildende/r: {{ Auth::user()->name }}</div>

        <?php $locationByPortfolio = []; ?>
        <?php $persons = []; ?>
        <?php /** @var $_entry App\Entry */ ?>
        @foreach($entries as $_entry)
            <?php /** @var $location App\Location */ ?>
            @if(!empty($location = $_entry->location()->first()))
                <?php
                if (!isset($locationByPortfolio[$_entry->portfolio_id][$location->getTypeTranslation()])) {
                    $locationByPortfolio[$_entry->portfolio_id][$location->getTypeTranslation()] = 1;
                } else {
                    $locationByPortfolio[$_entry->portfolio_id][$location->getTypeTranslation()]++;
                }

                if($location->additionals && $location->type == "business") {
                    if($location->additionals->trainer) {
                        $persons[] = $location->additionals->trainer;
                    }
                }
                ?>

            @else
                <?php
                if (!isset($locationByPortfolio[$_entry->portfolio_id]['Keine Angabe'])) {
                    $locationByPortfolio[$_entry->portfolio_id]['Keine Angabe'] = 1;
                } else {
                    $locationByPortfolio[$_entry->portfolio_id]['Keine Angabe']++;
                }
                ?>
            @endif
        @endforeach

        <div class="block">Ausbildende/r:</div>
        <?php $persons = array_unique($persons); ?>
        @foreach($persons as $_person)
            <div class="block"><div class="margin-l-25">{{ $_person }}</div></div>
        @endforeach

        @foreach($locationByPortfolio as $_portfolioId => $location)
            <?php $portfolio = (new \App\Portfolio)->find($_portfolioId); ?>
            <div class="block">Aufgabenbereich:  {{ $portfolio->sort . ". " . $portfolio->title }}</div>
            @foreach($location as $_location => $_count)
                <div class="block "><input type="checkbox" class="margin-l-25" /><div class="margin-l-50">Lernort {{ $_location }}, Anzahl: {{ $_count  }}</div></div>
            @endforeach
        @endforeach

        <div class="block">
            Bemerkungen: ___________________________________________________________________________________
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
            _____________________________________________<br/>
            Datum
        </div>

        <div class="sign">
            _____________________________________________<br/>
            Name, Unterschrift<br/>
            <span class="sub">(Mitglied Prüfungsausschuss)</span>
        </div>

        <div class="clearer"></div>

        <div class="attention">
            Achtung!<br/>
            Bitte diesen Korrekturbogen unbedingt an dieser Stelle im Berichtsheft belassen.
        </div>

    </div>

</div>