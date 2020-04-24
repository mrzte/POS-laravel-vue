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
         User::create([
            'name' => 'Maulana Sodiqin',
            'email' => 'you@me.com',
            'password' => bcrypt('password'),
            'status' => true
        ]);
    }
}
