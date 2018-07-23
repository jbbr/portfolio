@component('mail::message')
# Registrierung

Hallo {{ $user->name }},

vielen Dank für Deine Registrierung im Portfolio!<br>Um Deine Registrierung abzuschließen, klicke bitte folgenden Link:
@component('mail::button', ['url' => route('register.verify', $user->email_token), 'color' => 'green'])
Registrierung bestätigen
@endcomponent

Wir wünschen Dir viel Spaß mit dem Portfolio.<br>Nutze die Hilfe- und FAQ-Seiten für Deine ersten Schritte in der Anwendung.

Danke, das Portfolio-Team
@endcomponent
