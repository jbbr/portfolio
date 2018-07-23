@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    @include('partials.flash')
    @include('partials.content-header', [
        'title' => 'Administration',
        'divider' => false,
        'create' => route('locations.create'),
        'help' => Config::get('help.admin.users.create'),
        'addtext' => 'Benutzer hinzufügen',
    ])

    @include('admin.partials.tabs')


    <form action="{{ route('admin.config.store')  }}" method="POST" class="ui form" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="ui middle aligned grid">

            <div class="row">
                <div class="four wide column">
                    <label for="name">Logo</label>
                </div>
                <div class="seven wide column">

                    @if($config->getConfig('system_logo'))
                        <img src="{{ $config->getConfigPictureUrl('system_logo') }}" style="max-width: 200px; max-height: 200px;">
                    @endif

                    <input type="file" id="system_logo" name="system_logo">
                </div>
            </div>
            @if($config->getConfig('system_logo'))
                <div class="row">
                    <div class="four wide column">
                        <label for="name">Logo entfernen:</label>
                    </div>
                    <div class="seven wide column">
                        <div class="ui checkbox">
                            <input type="checkbox" name="system_logo_delete" value="{{ $config->getConfigPictureUrl('system_logo') }}"/>
                            <label></label>
                        </div>
                    </div>
                </div>
            @endif

            @foreach(range(1,5) as $_nr)

                <div class="row">
                    <div class="four wide column">
                        <label for="name">Footer - Logo {{ $_nr }}.</label>
                    </div>
                    <div class="seven wide column">

                        @if($config->getConfig('system_footer_' . $_nr))
                            <img src="{{ $config->getConfigPictureUrl('system_footer_' . $_nr) }}" style="max-width: 200px; max-height: 200px;">
                        @endif

                        <input type="file" id="system_footer_{{ $_nr }}" name="system_footer_{{ $_nr }}">
                    </div>
                </div>
                @if($config->getConfig('system_footer_' . $_nr))
                    <div class="row">
                        <div class="four wide column">
                            <label for="name">Footer - Logo {{ $_nr }}. entfernen:</label>
                        </div>
                        <div class="seven wide column">
                            <div class="ui checkbox">
                                <input type="checkbox" name="system_footer_{{ $_nr }}_delete" value="{{ $config->getConfig('system_footer_' . $_nr) }}"/>
                                <label></label>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach

            <div class="row">
                <div class="four wide column">
                    <label for="name">Layout - Farbe (Hell)</label>
                </div>
                <div class="seven wide column">
                    <div type="text" id="ci_color_light" class="color_select_element"></div>

                </div>
            </div>

            <div class="row">
                <div class="four wide column">
                    <label for="ci_color_light_input">Layout - Farbe (Hell) [Hex]</label>
                </div>
                <div class="seven wide column">
                    <input type="text" name="ci_color_light" id="ci_color_light_input" value="{{ $config->getConfig('ci_color_light') ?: '#00a2b1' }}" class="color_select_input ci_color_light">
                </div>
            </div>

            <div class="row">
                <div class="four wide column">
                    <label for="ci_color_dark">Layout - Farbe (Dunkel)</label>
                </div>
                <div class="seven wide column">
                    <div type="text" id="ci_color_dark" class="color_select_element"></div>
                </div>
            </div>

            <div class="row">
                <div class="four wide column">
                    <label for="ci_color_dark_input">Layout - Farbe (Dunkel) [Hex]</label>
                </div>
                <div class="seven wide column">
                    <input type="text" name="ci_color_dark" id="ci_color_dark_input" value="{{ $config->getConfig('ci_color_dark') ?: '#394e62' }}" class="color_select_input ci_color_dark">
                </div>
            </div>

            <div class="row">
                <div class="four wide column">
                </div>
                <div class="seven wide column">
                    <button type="submit" class="ui primary button">Speichern</button> Diese Aktion kann einen Moment dauern.
                </div>
            </div>



        </div>
    </form>

@endsection
