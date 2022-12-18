<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\RealState;

class Address extends Model
{
    use HasFactory;

    public function City(){
        return $this->belongsTo(City::class);
    }
    public function realstate(){
        return $this->hasMany(RealState::class);
    }
}
