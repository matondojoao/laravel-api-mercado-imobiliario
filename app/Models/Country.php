<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Country extends Model
{
    use HasFactory;

    public function States(){
        return $this->hasMany(State::class);
    }
    public function Addresses(){
        return $this->hasMany(Address::class);
    }
}
