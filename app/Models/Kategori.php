<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Table, Fillable};

#[Table('kategori')]
#[Fillable(['nama', 'tipe', 'user_id'])]
class Kategori extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
