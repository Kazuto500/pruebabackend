<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    use HasFactory;

    public function boxes()
    {
        return $this->belongsTo(Box::class);
    }

    //Relación uno a muchos
    public function steps()
    {
        return $this->hasMany(Steps::class);
    }
}
