@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Profil',
        'divider' => false,
        'edit' => route('profile.edit'),
        'help' => Config::get('help.profile.personal'),
    ])
    <p>Hier kannst du Deine Benutzerdaten, Lernorte, Aufgabenbereiche und öffentliche Freigaben verwalten.</p>
    <div class="ui divider dotted"></div>
    @include('profile.partials.tabs')
    <div class="ui middle aligned grid">
        <div class="row">
            <div class="four wide column">
                <label>Name</label>
            </div>
            <div class="six wide column">
                {{ $user->name }}
            </div>
        </div>
        @if(!is_null($user->email))
        <div class="row">
            <div class="four wide column">
                <label>E-Mail</label>
            </div>
            <div class="six wide column">
                {{ $user->email }}
            </div>
        </div>
        @endif
        <div class="row">
            <div class="four wide column">
                <label>Beruf</label>
            </div>
            <div class="six wide column">
                {{ $user->profession }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Geburtsdatum</label>
            </div>
            <div class="six wide column">
                {{ $user->date_of_birth }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Geburtsort</label>
            </div>
            <div class="six wide column">
                {{ $user->location_of_birth }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Anschrift</label>
            </div>
            <div class="six wide column">
                {{ $user->street }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Postleitzahl / Ort</label>
            </div>
            <div class="six wide column">
                {{ $user->city }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Telefon</label>
            </div>
            <div class="six wide column">
                {{ $user->phone }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Höchster Bildungsabschluss</label>
            </div>
            <div class="six wide column">
                {{ $user->education }}
            </div>
        </div>
        <div class="row">
            <div class="four wide column">
                <label>Ausbildungszeit</label>
            </div>
            <div class="six wide column">
                {{ $user->training_date_from }} bis {{ $user->training_date_to }}
            </div>
        </div>
    </div>
@endsection
