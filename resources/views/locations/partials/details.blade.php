<p>Beschreibung: {{ $location->description }}</p>
<p>Ansprechperson: {{ $location->person }}</p>
<p>E-Mail: {{ $location->email }}</p>
<p>Telefon: {{ $location->phone }}</p>
<p>Anschrift: {{ $location->street }}</p>
<p>Postleitzahl / Ort: {{ $location->city }}</p>
@foreach(LocationAdditions::getGeneralFields() as $id => $name)
    <p>{{ $name }}: {{ $location->additionals ? $location->additionals->$id : null }}</p>
@endforeach
@if($location->type && $location->type != 'general')
    @foreach(LocationAdditions::getFields($location->type) as $id => $name)
        <p>{{ $name }}: {{ $location->additionals ? $location->additionals->$id : null }}</p>
    @endforeach
@endif
