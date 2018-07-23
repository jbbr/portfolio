<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entries')->insert([
            'title' => 'Schaltung in Betrieb genommen',
            'description' => 'Schaltung in Betrieb genommen',
            'date' => Carbon::createFromDate(2017, 1, 1, 'Europe/Berlin'),
            'portfolio_id' => 1,
        ]);
        DB::table('entries')->insert([
            'title' => 'Installation von Steckdosen',
            'description' => 'Installation von Steckdosen',
            'date' => Carbon::createFromDate(2017, 1, 1, 'Europe/Berlin'),
            'portfolio_id' => 1,
        ]);
        DB::table('entries')->insert([
            'title' => 'Arbeitsvorbereitung durchgeführt',
            'description' => 'Arbeitsvorbereitung durchgeführt',
            'date' => Carbon::createFromDate(2017, 1, 1, 'Europe/Berlin'),
            'portfolio_id' => 1,
        ]);
        DB::table('entries')->insert([
            'title' => 'Installation von Dosen im Neubau durchgeführt',
            'description' => 'Installation von Dosen im Neubau durchgeführt',
            'date' => Carbon::createFromDate(2017, 1, 1, 'Europe/Berlin'),
            'portfolio_id' => 1,
        ]);
        DB::table('entries')->insert([
            'title' => 'Serienschalter montiert',
            'description' => 'Serienschalter montiert',
            'date' => Carbon::createFromDate(2017, 1, 1, 'Europe/Berlin'),
            'portfolio_id' => 1,
        ]);
        DB::table('entries')->insert([
            'title' => 'Werkzeuge und Materialien kennenlernen',
            'description' => 'Werkzeuge und Materialien kennenlernen',
            'date' => Carbon::createFromDate(2017, 1, 1, 'Europe/Berlin'),
            'portfolio_id' => 1,
        ]);
    }
}
