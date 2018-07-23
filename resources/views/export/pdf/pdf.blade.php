<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">

    @include('export.pdf.css')
</head>
<body>

<div class="puncher-hole top"></div>
<div class="puncher-hole bottom"></div>

@if( $type == "individual")
    @include('export.pdf.cover')
@else
    <!-- --- Load the front pages / cover for the explicit pdf --- -->
@endif

<div class="header">
    @if( $type == "individual")
        Individueller Projektbericht <span class="green">|</span> <span class="pagenum"></span>
    @endif
</div>

@if( $type == "explicit")
    @include('export.pdf.profile')
    <div class="page-break"></div>
    @include('export.pdf.profile2')
@endif

@if( $entries->count() )
    @if( $type == "explicit" )
        <div class="page-break"></div>
    @endif
    <div class="content">
        <?php $portfolio = ""; ?>
        @foreach( $entries as $_entry )

            @if($type == "explicit")
                @if($loop->first || ($portfolio != $_entry->portfolio()->first()->title))
                    <?php $portfolio = $_entry->portfolio()->first()->title; ?>
                    @include('export.pdf.report-cover', [
                        'portfolio' => $portfolio
                    ])
                    <div class="page-break"></div>
                @endif
                @include('export.pdf.entry')
            @endif

            @if($type == "individual")
                @include('export.pdf.entry-indiv')
            @endif

            @if(!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach

    </div>
@endif

@include('export.pdf.attach')
</body>
</html>
