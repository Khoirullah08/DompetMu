<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
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
        Kategori::factory()->create([
            'nama' => 'jajan',
            'tipe' => 'pengeluaran',
        ]);

        Kategori::factory()->create([
            'nama' => 'nabung',
            'tipe' => 'pemasukan',
        ]);
    }
}
