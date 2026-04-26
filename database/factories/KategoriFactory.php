<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class KategoriFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'nama' => '',
            'tipe' => '',
        ];
    }

}
