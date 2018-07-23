<div class="ui two column top aligned grid">
    <div class="eight wide column">
        <div class="ui ep card">
            <div class="content">
                <div class="header">Individueller Bericht</div>
            </div>
            <div class="content light">
                <div class="ui middle aligned grid">
                    <div class="five wide column">
                        <label for="title">Titel</label>
                    </div>
                    <div class="eleven wide column">
                        <div class="ui fluid input">
                            <input type="text" placeholder="Titel" name="title" id="title" value="{{ old('title') }}">
                        </div>
                    </div>

                    <div class="five wide column">
                        <label for="description">Untertitel</label>
                    </div>
                    <div class="eleven wide column">
                        <div class="ui fluid input">
                            <input type="text" placeholder="Untertitel" name="description" id="description" value="{{ old('description') }}">
                        </div>
                    </div>

                    <!--
                    <div class="five wide column">
                        <label for="sort-type">Gruppierung</label>
                    </div>
                    <div class="eleven wide column">
                        <select name="sort-type" id="sort-type">
                            <option value="locations">nach Lernorten</option>
                            <option value="tags">nach Schlagworte</option>
                            <option value="portfolios">nach Aufgabenbereichen</option>
                        </select>
                    </div>
                    -->

                    <div class="five wide column">
                        <label for="sort-type"> Einträge sortieren nach:</label>
                    </div>

                    <div class="eleven wide column">
                        <select name="sort-date">
                            <option value="asc">Datum aufwärts</option>
                            <option value="desc">Datum abwärts</option>
                        </select>
                    </div>

                    <div class="sixteen wide column">
                        <button type="submit" name="preview_individual" class="ui button primary right floated">Ausgabe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="eight wide column">
        <div class="ui top aligned grid">
            <div class="sixteen wide column centered">
                <div class="ui ep card">
                    <div class="content">
                        <div class="header">Ausbildungsnachweis</div>
                    </div>
                    <div class="content light">
                        <div class="ui center aligned grid">
                            <div class="sixteen wide column">
                                <button type="submit" name="preview_explicit" class="ui button primary right floated">Ausgabe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
