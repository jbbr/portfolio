@extends('layouts.app')

@section('title', 'Passwort zurücksetzen')
@section('content-width', 'small')

@section('content')
    @include('partials.flash')
    <h1>Passwort zurücksetzen</h1>
    <p>
        Gib hier Deine E-Mail-Adresse, mit der
        Du Dich registriert hast, ein. Du erhältst
        dann eine E-Mail, mit der Du Dein Passwort
        zurücksetzen kannst.
    </p>
    <form class="ui form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="field {{ $errors->has('email') ? 'error' : null }}">
            <input type="text" name="email" placeholder="E-Mail" required autofocus value="{{ old('email') }}">
        </div>
        <div class="field">
            <button type="submit" class="ui primary button">E-Mail senden</button>
        </div>
    </form>
@endsection
