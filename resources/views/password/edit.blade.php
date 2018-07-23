@extends('layouts.app')

@section('title', 'Passwort')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Passwort ändern',
        'divider' => false,
    ])
    @include('profile.partials.tabs')
    <div class="ui divider dotted"></div>
    <form action="{{ route('password.update') }}" method="POST" class="ui form">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="ui middle aligned grid">
            <div class="row">
                <div class="three wide column">
                    <label for="current_password">Aktuelles Passwort</label>
                </div>
                <div class="six wide column">
                    <input type="password" id="current_password" name="current_password">
                </div>
            </div>
            <div class="row">
                <div class="three wide column">
                    <label for="password">Neues Passwort</label>
                </div>
                <div class="six wide column">
                    <input type="password" id="password" name="password">
                </div>
            </div>
            <div class="row">
                <div class="three wide column">
                    <label for="password_confirmation">Passwort wiederholen</label>
                </div>
                <div class="six wide column">
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>
            <div class="row">
                <div class="three wide column">
                </div>
                <div class="six wide column">
                    <button type="submit" class="ui primary button">Speichern</button>
                    <a href="{{ route('profile.edit') }}" type="submit" class="ui secondary button">Abbrechen</a>
                </div>
            </div>
        </div>
    </form>
@endsection
