<?php

namespace Database\Seeders;

use App\Models\Securite\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'point_de_vente_id' => 1,
            'is_active' => true,
        ]);

        // Attribuer le rôle Super Administrateur
        $admin->assignRole('Super Administrateur');
    }
}
