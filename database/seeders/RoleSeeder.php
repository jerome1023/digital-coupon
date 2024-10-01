<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

use function Laravel\Prompts\table;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => Uuid::uuid4(),
                'name' => 'admin'
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'store_owner'
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'customer'
            ]
        ]);
    }
}
