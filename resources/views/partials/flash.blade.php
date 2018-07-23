@if (session('status'))
    <div class="ui success message">
        <i class="close icon"></i>
        <div>
            {{ session('status') }}
        </div>
    </div>
@endif

@if (session('failed'))
    <div class="ui error message">
        <i class="close icon"></i>
        <div>
            {{ session('failed') }}
        </div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="ui negative message">
        <i class="close icon"></i>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
