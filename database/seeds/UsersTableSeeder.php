<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
    }
}
