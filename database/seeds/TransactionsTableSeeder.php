<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            'account_id' => 2,
            'transaction_item_id' => 1,
            'date' => Carbon::now()
                ->format('Y-m-d'),
            'credit' => 0.00,
            'running_balance' => 0.00,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
