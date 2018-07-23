@extends('layouts.app')

@section('title', 'Passwort zurücksetzen')
@section('content-width', 'small')

@section('content')
    @include('partials.flash')
    <h1>Passwort zurücksetzen</h1>
    <p>
        Gib hier Deine E-Mail-Adresse, mit der
        Du Dich registriert hast, ein und vergebe
        ein neues Passwort.
    </p>
    <form class="ui form" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="field {{ $errors->has('email') ? 'error' : null }}">
            <input type="text" name="email" placeholder="E-Mail" required autofocus value="{{ old('email') }}">
        </div>
        <div class="field {{ $errors->has('password') ? 'error' : null }}">
            <input type="password" name="password" placeholder="Passwort" required>
        </div>
        <div class="field {{ $errors->has('password') ? 'error' : null }}">
            <input type="password" name="password_confirmation" placeholder="Passwort wiederholen" required><br>
        </div>
        <div class="field">
            <button type="submit" class="ui primary button">Passwort speichern</button>
        </div>
    </form>
@endsection
