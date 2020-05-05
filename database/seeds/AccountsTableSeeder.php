<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            ['owner_id' => 1, 'account_type_id' => 1, 'name' => 'sale',
            'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')],
            ['owner_id' => 2, 'account_type_id' => 2, 'name' => 'earning',
            'created_at' =>  Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' =>  Carbon::now()->format('Y-m-d H:i:s')]
            ]);
    }
}
