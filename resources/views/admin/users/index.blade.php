@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Administration',
        'divider' => false,
        'create' => route('admin.user.create'),
        'addtext' => 'Benutzer hinzufügen',
    ])

    @include('admin.partials.tabs')

    <div class="ui grid">
        <div class="sixteen wide column">
            @include('partials.pagination', ['paginator' => $users])
            <table class="ui very basic compact table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Admin</th>
                    <th class="right aligned">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            @if($user->isAdmin())
                                <i class="check icon" style="color: green;"></i>
                            @else
                                -
                            @endif
                        </td>

                        <td class="align right">
                            <div class="actions">
                                <div class="actions">
                                    <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}"
                                          onsubmit="return confirm('Benutzer wirklich löschen?')">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="ui icon right floated button" data-content="Löschen">
                                            <i class="trash icon"></i>
                                        </button>
                                    </form>
                                    <a class="ui icon right floated button" href="{{ route('admin.user.edit', $user->id) }}" data-content="Bearbeiten">
                                        <i class="edit icon"></i>
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>

                @endforeach
            </table>
            @include('partials.pagination', ['paginator' => $users])
        </div>
    </div>

@endsection