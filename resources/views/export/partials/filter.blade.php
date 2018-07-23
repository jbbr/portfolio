<div class="ui middle aligned grid left aligned calendar-group filter">

    <div class="row">
        <div class="sixteen wide column"><h2 class="green colored">Filter</h2></div>
    </div>

    <div class="row">

        <div class="three wide column">
            <label for="portfolios">Aufgabenbereich</label>
        </div>

        <div class="four wide column">
            <div id="portfolios" class="ui fluid multiple search selection dropdown no-addition" onkeypress="return event.keyCode != 13;">
                <input name="portfolios" type="hidden" value="{{ old('portfolios') }}"/>
                <i class="dropdown icon"></i>
                <div class="default text">Aufgabenbereich</div>
                <div class="menu">
                    @foreach($portfolios as $_portfolio)
                        <div class="item" data-value="{{ $_portfolio->id }}">{{ $_portfolio->title }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="one wide column"></div>

        <div class="two wide column">
            <label for="date_from">Zeitraum von</label>
        </div>
        <div class="three wide column field">
            <div class="ui calendar date-from" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="date_from" name="date_from" placeholder="22.03.2017" value="{{ old('date_from') }}"/>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="three wide column">
            <label for="tags">Lernorte</label>
        </div>

        <div class="four wide column">
            <div id="locations" class="ui fluid multiple search selection dropdown no-addition" onkeypress="return event.keyCode != 13;">
                <input name="locations" type="hidden" value="{{ old('locations') }}"/>
                <i class="dropdown icon"></i>
                <div class="default text">Lernorte</div>
                <div class="menu">
                    @foreach($locations as $_location)
                        <div class="item" data-value="{{ $_location->id }}">{{ $_location->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="one wide column"></div>

        <div class="two wide column">
            <label for="date_to"> bis</label>
        </div>
        <div class="three wide column field">
            <div class="ui calendar date-to" data-calendar-type="date">
                <div class="ui input left icon fluid">
                    <i class="calendar icon"></i>
                    <input type="text" id="date_to" name="date_to" placeholder="22.03.2017" value="{{ old('date_to') }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="three wide column">
            <label for="tags">Schlagwörter</label>
        </div>

        <div class="four wide column">
            <div id="tags" class="ui fluid multiple search selection dropdown no-addition" onkeypress="return event.keyCode != 13;">
                <input name="tags" type="hidden" value="{{ old('tags') }}"/>
                <i class="dropdown icon"></i>
                <div class="default text">Schlagwörter</div>
                <div class="menu">
                    @foreach($tags as $_tag)
                        <div class="item" data-value="{{ $_tag->id }}">{{ $_tag->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
