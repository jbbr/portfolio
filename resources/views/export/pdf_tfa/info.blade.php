@extends('layouts.app')

@section('title', 'Fehler beim Erstellen des PDFs')
@section('content-width', 'small')

@section('content')
    <h1>Fehler beim Erstellen des PDFs</h1>
    <p>
        Ihre PDF konnte nicht erzeugt werden.<br/>
        Bitte wählen Sie mindestens einen Eintrag aus, welcher ausgegeben werden soll.<br/>
        <br/>
        Diese Seite wird sich in 5 Sekunden selber schließen.
    </p>
    <script>
        var isIE = !!navigator.userAgent.match(/Trident/g) || !!navigator.userAgent.match(/MSIE/g);
        window.setTimeout(function () {
            if(!isIE) {
                window.close();
            } else {
                window.history.back();
            }
        }, 5000);
    </script>
@endsection

