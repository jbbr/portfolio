{{ csrf_field() }}
<div class="ui equal width grid location-form">
    <div class="row">
        <div class="four wide column">
            <label for="name">Name</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="name" name="name" placeholder="Gib hier ein, wie Dein Lernort heißt" value="{{ $location ? $location->name : old('name') }}" required>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label>Typ des Lernorts</label>
        </div>
        <div class="eight wide column">
            <select id="type" name="type" onchange="locations.updateFields()">
                <option value="general">Allgemein</option>
                @foreach(LocationAdditions::getTypes() as $id => $name)
                    <option value="{{ $id }}" {{ $location && $location->type === $id ? 'selected' : null }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="description">Beschreibung</label>
        </div>
        <div class="eight wide column">
            <textarea name="description" placeholder="Beschreibe Deinen Lernort">{{ $location ? $location->description: old('description') }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="person">Ansprechperson</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="person" name="person" placeholder="Deine Ansprechperson am Lernort" value="{{ $location ? $location->person: old('person') }}">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="email">E-Mail</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="email" name="email" placeholder=" E-Mail-Adresse Deines Lernortes/Deiner Ansprechperson" value="{{ $location ? $location->email: old('email') }}">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="phone">Telefon</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="phone" name="phone" placeholder="Telefonnummer Deines Lernortes/Deiner Ansprechperson" value="{{ $location ? $location->phone: old('phone') }}">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="street">Anschrift</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="street" name="street" placeholder="Anschrift Deines Lernortes" value="{{ $location ? $location->street: old('street') }}">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="city">Postleitzahl / Ort</label>
        </div>
        <div class="eight wide column">
            <input type="text" id="city" name="city" placeholder="Postleitzahl und Ort Deines Lernortes" value="{{ $location ? $location->city: old('city') }}">
        </div>
    </div>
    @foreach(LocationAdditions::getGeneralFields() as $id => $name)
        <div class="row">
            <div class="four wide column">
                <label for="{{ $id }}">{{ $name }}</label>
            </div>
            <div class="eight wide column">
                <input type="text" id="{{ $id }}" name="{{ $id }}"
                       value="{{ $location && $location->additionals ? $location->additionals->$id : old($id) }}">
            </div>
        </div>
    @endforeach
    @foreach(LocationAdditions::getTypes() as $typeId => $name)
        @foreach(LocationAdditions::getFields($typeId) as $id => $name)
            <div class="row" data-type="{{ $typeId }}">
                <div class="four wide column">
                    <label for="{{ $id }}">{{ $name }}</label>
                </div>
                <div class="eight wide column">
                    <input type="text" id="{{ $id }}" name="{{ $id }}"
                           value="{{ $location && $location->additionals ? $location->additionals->$id : old($id) }}">
                </div>
            </div>
        @endforeach
    @endforeach
    <div class="row">
        <div class="four wide column"></div>
        <div class="eight wide column">
            <button type="submit" class="ui primary button">Speichern</button>
            <a href="{{ route('locations.index') }}" class="ui secondary button">Abbrechen</a>
        </div>
    </div>
</div>
