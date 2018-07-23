<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">

    @include('export.pdf_tfa.css')
</head>
<body>

<div class="puncher-hole top"></div>
<div class="puncher-hole bottom"></div>

@if( $type == "individual")
    @include('export.pdf_tfa.cover')
@else
    <!-- --- Load the front pages / cover for the explicit pdf --- -->
@endif

<div class="header">
    @if( $type == "individual")
        Individueller Projektbericht <span class="green">|</span> <span class="pagenum"></span>
    @endif
</div>

@if( $type == "explicit")

    @include('export.pdf_tfa.profile')
    <div class="page-break"></div>
    @include('export.pdf_tfa.profile2')

@endif

@if( $entries->count() )
    @if( $type == "explicit" )
        <div class="page-break"></div>
    @endif
    <div class="content">
        <?php $parts = [1, 1]; ?>
        @foreach( $entries as $_entry )
            @if( $type == "explicit")
                @if( ($_entry->tags->contains("name", "Zusammenfassung") || $_entry->tags->contains("name", "Schwerpunktthema")) && $parts[0] == 1 )
                    @include('export.pdf_tfa.report-cover-summary')
                    <div class="page-break"></div>
                    <?php $parts[0] = 2; ?>
                @endif

                @if( $_entry->tags->contains("name", "Quartalsbericht") && $parts[1] == 1 )
                    @include('export.pdf_tfa.report-cover-quarter')
                    <div class="page-break"></div>
                    <?php $parts[1] = 2; ?>
                @endif
            @endif

            @if( $type == "individual")
                @include('export.pdf_tfa.entry-indiv')
            @else
                @include('export.pdf_tfa.entry')
            @endif

            @if( !$loop->last )
                <div class="page-break"></div>
            @endif

        @endforeach

    </div>
@endif

@include('export.pdf_tfa.attach')
</body>
</html>
