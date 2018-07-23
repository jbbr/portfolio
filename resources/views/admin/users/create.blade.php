@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Benutzer erstellen',
        'divider' => true,
    ])

    <form action="{{ route('admin.user.store')  }}" method="POST" class="ui form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('admin.users.partials.form', ['user' => $user])
    </form>

@endsection