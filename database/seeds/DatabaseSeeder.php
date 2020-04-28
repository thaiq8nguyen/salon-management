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
        DB::table('users')->insert([['first_name' => 'Thai', 'last_name' => 'Nguyen',
            'email' => 'thai@thaiqnguyen.com', 'password' => bcrypt('thai')],
            ['first_name' => 'Annie', 'last_name' => 'Le',
            'email' => 'ale@anniele.net', 'password' => bcrypt('annie')]]);

        DB::table('roles')->insert([['name' => 'manager'],['name' => 'technician']]);
        DB::table('role_user')->insert([['role_id' => 1, 'user_id' => 1],
            ['role_id' => 2, 'user_id' => 2]]);
    }
}
