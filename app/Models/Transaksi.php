<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Table, Fillable};

#[Table("transaksi")]
#[Fillable(["user_id", "dompet_id", "kategori_id", "tipe", "jumlah", "catatan", "tanggal"])]

// relasi antar Models
class Transaksi extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dompet()
        {
            return $this->belongsTo(Dompet::class);
        }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
