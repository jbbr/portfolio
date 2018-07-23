@if( $type == "individual" )
    @include('export.pdf.media-indiv')
@else
    @include('export.pdf.media')
@endif