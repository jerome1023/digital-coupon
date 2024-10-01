<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'admin')->first();
        User::create([
                'id' => Uuid::uuid4(),
                'first_name' => "Admin",
                'last_name' => "Account",
                'username' => "admin",
                'role_id' => $role->id,
                'password' => Hash::make("admin123")
            ]);
    }
}
