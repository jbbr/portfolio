<div class="profile">
    <div class="title">Schriftlicher Ausbildungsnachweis</div>
    <div class="sub_title">für die Ausbildung zum/zur {{ Auth::user()->profession }}</div>
    <div class="informations">
        <div class="block">Vorname/Name: {{ Auth::user()->name }}</div>
        <div class="block">Geburtsdatum und -ort: {{ Auth::user()->date_of_birth }}, {{ Auth::user()->location_of_birth }}</div>
        <div class="block">Anschrift Straße/Nr.:  {{ Auth::user()->street }}</div>
        <div class="block">PLZ / Ort:  {{ Auth::user()->city }}</div>
        <div class="block">Rufnummer:  {{ Auth::user()->phone }}</div>
        <div class="block">Schulabschluss der allg.bild. Schule: {{ Auth::user()->education }}</div>
        @foreach($additionals as $addition)
            <div class="block">{{ $addition[0] }}: {{ $addition[1] }}</div>
        @endforeach
        <div class="block">Ausbildungszeit von: {{ Auth::user()->training_date_from }} bis: {{ Auth::user()->training_date_to }}</div>
    </div>

</div>
