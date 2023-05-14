<?php

namespace database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->updateOrInsert([
            'id'              => 1,
            'name'            => 'Admin',
            'email'           => 'admin@gmail.com',
            'password'        => Hash::make('admin'),
            'account_type_id' => 1,
        ]);
    }
}
