@extends('layouts.app')

@section('title', 'Impressum')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', ['title' => 'Impressum'])

    <p>Trotz unserer sorgfältigen Bemühungen können wir keine Gewähr für die Richtigkeit, Vollständigkeit und Aktualität
        unserer Webseiten geben. Weiter Übernehmen wir keine
        Haftung für die Inhalte externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber
        verantwortlich.</p>
    <h2 class="green colored">Angaben gemäß § 5 TMG:</h2>
    <p>Institut für Technische Bildung und Hochschuldidaktik<br>
        TUHH iTBH G-3<br>
        Am Irrgarten 3-9<br>
        21073 Hamburg</p>
    <h2 class="green colored">Vertreten durch:</h2>
    <p>Prof. Dr. Sönke Knutzen</p>
    <p>Kontakt:<br>
        Telefon: 040428783607<br>
        Telefax: 040428784064<br>
        E-Mail: itbh@tuhh.de</p>
@endsection
