<div class="ui middle aligned grid">
    <div class="row">
        <div class="four wide column">
            <label for="name">Profilbild</label>
        </div>
        <div class="seven wide column">

            @if($pic = $user->getPicturePath())
                <img src="{{ $pic }}" style="max-width: 200px; max-height: 200px;">
            @endif

            <input type="file" id="picture" name="picture">
        </div>
    </div>
    @if($pic = $user->getPicturePath())
        <div class="row">
            <div class="four wide column">
                <label for="name">Profilbild entfernen:</label>
            </div>
            <div class="seven wide column">
                <div class="ui checkbox">
                    <input type="checkbox" name="picture_delete" value="{{ $user->picture }}"/>
                    <label></label>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="four wide column">
            <label for="name">Name</label>
        </div>
        <div class="seven wide column">
            <input type="text" value="{{ old('name', $user->name) }}" id="name" name="name">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label>E-Mail</label>
        </div>
        <div class="seven wide column">
            <div class="ui input fluid{{ $user->email ? " disabled" : "" }}">
                <input type="text" value="{{ old('email', $user->email) }}"{{ $user->email ? "" : " name=email" }}>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="profession">Beruf</label>
        </div>
        <div class="seven wide column">
            <input type="text" value="{{ old('profession', $user->profession) }}" id="profession" name="profession">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="date_of_birth">Geburtsdatum</label>
        </div>
        <div class="seven wide column">
            <div class="ui calendar" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="date_of_birth" name="date_of_birth" placeholder="25.03.1992"
                           value="{{ old('date_of_birth', $user->date_of_birth) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="location_of_birth">Geburtsort</label>
        </div>
        <div class="seven wide column">
            <input type="text" id="location_of_birth" name="location_of_birth"
                   value="{{ old('location_of_birth', $user->location_of_birth) }} ">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="street">Anschrift</label>
        </div>
        <div class="seven wide column">
            <input type="text" value="{{ old('street', $user->street) }}" id="street" name="street">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="city">Postleitzahl / Ort</label>
        </div>
        <div class="seven wide column">
            <input type="text" value="{{ old('city', $user->city) }}" id="city" name="city">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="phone">Telefon</label>
        </div>
        <div class="seven wide column">
            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="education">Höchster Bildungsabschluss</label>
        </div>
        <div class="seven wide column">
            <input type="text" id="education" name="education" value="{{ old('education', $user->education) }}">
        </div>
    </div>
    <div class="row calendar-group">
        <div class="four wide column">
            <label for="training_date_from">Ausbildungszeit</label>
        </div>
        <div class="three wide column">
            <div class="ui calendar date-from" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="training_date_from" name="training_date_from"
                           value="{{ old('training_date_from', $user->training_date_from) }}">
                </div>
            </div>
        </div>
        <div class="one wide column">
            bis:
        </div>
        <div class="three wide column">
            <div class="ui calendar date-to" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="training_date_to" name="training_date_to"
                           value="{{ old('training_date_to', $user->training_date_to) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="eleven wide column">
            <div class="ui divider dotted"></div>
        </div>
    </div>

    <div class="row">
        <div class="four wide column">
            <label for="password">Passwort</label>
        </div>
        <div class="seven wide column">
            <input type="password" id="password" name="password">
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="password_confirmation">Passwort wiederholen</label>
        </div>
        <div class="seven wide column">
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
    </div>
    <div class="row">
        <div class="eleven wide column">
            <div class="ui divider dotted"></div>
        </div>
    </div>
    <div class="row">
        <div class="four wide column">
            <label for="name">Ist Admin:</label>
        </div>
        <div class="seven wide column">
            <div class="ui checkbox">
                <input type="checkbox" name="is_admin" {{ old('is_admin',$user->is_admin) == 1 ? "checked=checked" : ""  }}"/>
                <label></label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="four wide column">
        </div>
        <div class="seven wide column">
            <button type="submit" class="ui primary button">Speichern</button>
            <a href="{{ route('admin.users.index') }}" type="submit" class="ui secondary button">Abbrechen</a>
        </div>
    </div>
</div>