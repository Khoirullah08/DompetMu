<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
           'name' => 'Juliansa',
            'email' => 'juliansa@gmail.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'password' => Hash::make('juliansa@gmail.com'),
        ]);

        // Kategori::factory()->create([
        //     'nama' => 'jajan',
        //     'tipe' => 'pengeluaran',
        // ]);

        // Kategori::factory()->create([
        //     'nama' => 'nabung',
        //     'tipe' => 'pemasukan',
        // ]);
    }
}
