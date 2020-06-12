<?php

use Illuminate\Database\Seeder;

class TechniciansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('technicians')->insert([
            ['first_name' => 'Annie', 'last_name' => "Le"],
            ['first_name' => 'Nguyen', 'last_name' => "Le"]
        ]);
    }
}
