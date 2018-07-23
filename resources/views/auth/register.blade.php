@extends('layouts.app')

@section('title', 'Anmelden')
@section('content-width', 'small')

@section('content')
    @include('partials.flash')
    <h1>Registrieren</h1>
    <form class="ui form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="field {{ $errors->has('name') ? 'error' : null }}">
            <input type="text" name="name" placeholder="Name" required autofocus value="{{ old('name') }}">
        </div>
        <div class="field {{ $errors->has('email') ? 'error' : null }}">
            <input type="text" name="email" placeholder="E-Mail" required value="{{ old('email') }}">
        </div>
        <div class="field {{ $errors->has('password') ? 'error' : null }}">
            <input type="password" name="password" placeholder="Passwort" required>
        </div>
        <div class="field {{ $errors->has('password_confirmation') ? 'error' : null }}">
            <input type="password" name="password_confirmation" placeholder="Passwort wiederholen" required><br>
        </div>
        <div class="field">
            <button type="submit" class="ui primary button">Registrieren</button>
        </div>
        <div class="field">
            <div class="ui divider dotted"></div>
        </div>
        <div class="field">
            <a href="{{ route('login') }}">Anmelden</a>
        </div>
    </form>
@endsection
