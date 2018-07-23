@extends('layouts.app')

@section('title', 'Anmelden')
@section('content-width', 'small')

@section('content')
    @include('partials.flash')
    <h1>Login</h1>
    <form class="ui form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="field {{ $errors->has('email') ? 'error' : null }}">
            <input type="text" name="email" placeholder="E-Mail" required autofocus value="{{ old('email') }}">
        </div>
        <div class="field {{ $errors->has('password') ? 'error' : null }}">
            <input type="password" name="password" placeholder="Passwort" required>
        </div>
        <div class="field">
            <button type="submit" class="ui primary button">Anmelden</button>
            <a href="{{ route('password.request') }}">Passwort vergessen?</a>
        </div>
        <div class="field">
            <div class="ui divider dotted"></div>
        </div>
        <div class="field">
            <a href="{{ route('register') }}">Registrieren</a>
        </div>
    </form>
@endsection
