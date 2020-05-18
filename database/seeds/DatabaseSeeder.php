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
            RolesTableSeeder::class,
            RolesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            AccountTypesTableSeeder::class,
            CompanyAccountsTableSeeder::class,
            TechnicianAccountsTableSeeder::class,
            TransactionItemsTableSeeder::class,
        ]);
    }
}
