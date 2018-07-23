<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mediathek</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="{{ mix('/js/app.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style>
        body > div.ui.divided.items {
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="ui divided items">
    @forelse($media as $_medium)
        @include('media.dialog.item', [
            'mediaInfo' => $_medium->mediaInfos->where('user_id', Auth::id())->first()
        ])
    @empty
        <div class="cta-text">
            <h2 class="green colored">Du hast noch keine Medien.</h2>
            <p>Lade neue Medien hoch oder klicke auf Hilfe um mehr über Medien zu erfahren.</p>
        </div>
    @endforelse
    <script>
        jQuery('.media-insert-btn').on('click', function () {
            var editor = top.tinymce.activeEditor;
            var path = jQuery(this).data('path');
            editor.insertContent('<img src="' + path + '"/>');
            editor.windowManager.close();
        });
    </script>
</div>
</body>
</html>