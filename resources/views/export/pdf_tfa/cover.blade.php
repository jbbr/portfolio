<div class="cover">
    <div class="title">{{ $title }}</div>
    <div class="description">{{ $description }}</div>

    <div class="hr green"></div>

    <div class="user">{{ Auth::user()->name }}</div>
    <div class="extra">Beruf: {{ Auth::user()->profession }}</div>

    <div class="hr green"></div>

    <div class="date_of_creation">Erstellungsdatum: {{ \Carbon\Carbon::now('Europe/Berlin')->format('d.m.Y') }}</div>
</div>

<div class="page-break"></div>
