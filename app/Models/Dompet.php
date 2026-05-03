<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Table, Fillable};

#[Table("dompet")]
#[Fillable(["nama", "total", "aktif", "user_id"])]
class Dompet extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
