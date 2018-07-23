<div class="entry">
    <div class="entry_head">
        <div class="title">Aufgabenbereich:</div>
        <div class="sub_title">{{ $_entry->portfolio->sort }}. {{ $_entry->portfolio->title }}</div>

        <div class="hr"></div>

        <div class="tags">
            Schlagwort:
            @foreach($_entry->tags as $tag)
                {{ $tag->name }}@if( !$loop->last ),@endif
            @endforeach
        </div>

        <div class="hr"></div>

        <div class="extra">
            <div class="left floated width-50">
                <span class="title">Name:</span>
                <span class="value">{{ Auth::user()->name }}</span>
            </div>
            <div class="left floated width-50">
                <span class="title">Lernort:</span>
                <span class="value">@if(!empty($_entry->location()->first())){{ $_entry->location()->first()->name }}@endif</span>
            </div>
            <div class="clearer"></div>

            <div class="left floated width-50">
                <span class="title">Datum:</span>
                <span class="value">{{ \Carbon\Carbon::parse($_entry->date)->format('d.m.Y') }}</span>
            </div>
            <div class="left floated width-50">
                <span class="title">Anzahl der Wörter:</span>
                <span class="value">{{ $_entry->wordcount }}</span>
            </div>
            <div class="clearer"></div>

            <div class="left floated width-100">
                <span class="title">Titel:</span>
                <span class="value">{{ $_entry->title }}</span>
            </div>
            <div class="clearer"></div>
        </div>


    </div>
    <div class="description">
        {!! str_replace("src=\"/storage/media/", "src=\"". url()->to("/") . "/storage/media/", $_entry->description) !!}
    </div>

    @include('export.pdf.entry-media')

    <div class="entry-footer">
        @if( $type == "explicit")
            <table>
                <tr>
                    <td>Auszubildende/r<br/>Unterschrift</td>
                    <td>Datum</td>
                    <td>Ausbilder/in<br/>Unterschrift</td>
                    <td>Datum</td>
                </tr>
                <tr>
                    <td>&nbsp;<br />&nbsp;</td>
                    <td>&nbsp;<br />&nbsp;</td>
                    <td>&nbsp;<br />&nbsp;</td>
                    <td>&nbsp;<br />&nbsp;</td>
                </tr>
            </table>
        @endif
    </div>

</div>
