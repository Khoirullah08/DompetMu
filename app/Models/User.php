<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden, Casts};

#[Fillable(['name', 'email', 'role', 'password'])]
#[Hidden(['password', 'remember_token'])]
#[Casts([
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function kategori()
    {
        return $this->hasMany(Kategori::class);
    }

    public function dompet()
    {
        return $this->hasMany(Dompet::class);
    }
}
