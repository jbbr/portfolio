<?php

use Illuminate\Database\Seeder;

class PortfolioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portfolios')->insert([
            'title' => 'Standard-Elektroanlagen',
            'description' => 'installieren und in Betrieb nehmen',
            'user_id' => 1,
        ]);
    }
}