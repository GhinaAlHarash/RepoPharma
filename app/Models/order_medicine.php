<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_medicine extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function medicines(){
        return $this->hasMany(medicine::class,'medicines');
    }

    public function orders(){
        return $this->hasMany(order::class,'orders');
    }
}
