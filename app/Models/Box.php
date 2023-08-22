<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    //Relación uno a muchos {inversa}
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relación uno a muchos
    public function powers()
    {
        return $this->hasMany(Power::class);
    }
}
