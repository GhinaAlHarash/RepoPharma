<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function classification()
    {
        return $this->belongsTo(classification::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);
    }

    public function orders(){
        return $this->belongsToMany(order::class,'order_medicines');
    }
}
