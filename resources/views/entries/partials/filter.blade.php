<div class="ui floating labeled icon dropdown small button" data-filter="location" data-content="Anzeige Einträge pro Lernort">
    <i class="filter icon"></i>
    <span class="text">Lernort</span>
    <div class="menu">
        <div class="header">
            Einträge pro Lernort
        </div>
        <div class="divider"></div>
        @foreach($locations as $location => $uses)
            <div class="item" data-location="{{ $location }}">
                @if($uses)
                    <span class="description"><b>{{ $uses }}</b></span>
                @endif
                <span class="text">{{ $location }}&nbsp;&nbsp;&nbsp;</span>
            </div>
        @endforeach
    </div>
</div>
<div class="ui divider dotted"></div>
