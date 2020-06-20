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
        $safeAccountType = DB::table('account_types')->where('name', 'safe')->first();
        $bankAccountType = DB::table('account_types')->where('name', 'bank')->first();
        $expensesAccountType = DB::table('account_types')->where('name', 'expenses')->first();
        $incomeAccountType = DB::table('account_types')->where('name', 'income')->first();

        DB::table('company_accounts')->insert([
            [
                'name' => 'cash',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_type_id' => $safeAccountType->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'checking account',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_type_id' => $bankAccountType->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'wages',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_type_id' => $expensesAccountType->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'credit card fee',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_type_id' => $expensesAccountType->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'sale commission',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_type_id' => $incomeAccountType->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'tip commission',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'account_type_id' => $incomeAccountType->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]

        ]);
    }
}
