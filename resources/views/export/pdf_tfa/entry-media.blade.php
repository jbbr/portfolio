@if( $type == "individual" )
    @include('export.pdf_tfa.media-indiv')
@else
    @include('export.pdf_tfa.media')
@endif