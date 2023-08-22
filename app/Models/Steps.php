<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Steps extends Model
{
    use HasFactory;

    //Relación uno a muchos {inversa}
    public function powers()
    {
        return $this->belongsTo(Power::class);
    }
}
