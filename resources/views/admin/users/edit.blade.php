@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Benutzer bearbeiten',
        'divider' => true,
    ])

    <form action="{{ route('admin.user.update', ['user' => $user->id]) }}" method="POST" class="ui form" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        @include('admin.users.partials.form', ['user' => $user])
    </form>

@endsection