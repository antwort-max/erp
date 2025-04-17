<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'system@cfc.cl'],
            [
                'name'              => 'Administrador',
                'password'          => Hash::make('mo20io30'),
                'email_verified_at' => now(),
            ]
        );
    }
}
