<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TechnicianDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('technician_details')->insert([
            ['technician_id' => 1],
            ['technician_id' => 2]
        ]);
    }
}
