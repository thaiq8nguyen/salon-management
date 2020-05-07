<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder:: class,
            RoleUserTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            AccountTypesTableSeeder::class,
            AccountsTableSeeder::class,
            TransactionItemsTableSeeder::class,
            TransactionsTableSeeder::class,
        ]);
    }
}
