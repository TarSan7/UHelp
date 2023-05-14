<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (AccountType::ACCOUNT_TYPES as $id => $type) {
            DB::table('account_types')->updateOrInsert([
                'id'   => $id,
                'name' => $type,
            ]);
        }
    }
}
