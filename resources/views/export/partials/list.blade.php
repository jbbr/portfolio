@if( !empty($entries) )
    <div class="ui divider dotted"></div>

    <div class="ui divided items checklist">
        <div class="item chbx-master">
            <div class="ui master checkbox">
                <input type="checkbox" name="">
                <label>Alle auswählen</label>
            </div>
        </div>
        @foreach($entries as $entry )
            @include('export.partials.entry')
        @endforeach

    </div>
@endif