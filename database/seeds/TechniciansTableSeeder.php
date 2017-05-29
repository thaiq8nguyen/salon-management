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
        factory(App\Technician::class,11)->create()->each(function($t){
            $t->salary()->save(factory(App\Salary::class)->make());
        });
    }
}
