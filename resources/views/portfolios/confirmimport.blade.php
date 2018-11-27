Folgende Aufgabenbereiche werden importiert:
@foreach($portfolios as $portfolio)
    <ul>
        <li>
            <strong>{{ $portfolio->title }}</strong><br>
            {{ $portfolio->subtitle }}
        </li>
    </ul>
@endforeach
<form method="POST" action="{{ route('portfolios.import', [], false) }}">
    {{ csrf_field() }}
    <input type="hidden" name="code" value="{{ $code }}">
</form>
