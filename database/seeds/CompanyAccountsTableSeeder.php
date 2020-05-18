<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CompanyAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_accounts')->insert([
            'name' => 'cash on hand',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
