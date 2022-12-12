<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Address;
use App\Models\State;

class City extends Model
{
    use HasFactory;

    public function Addresses(){
        return $this->hasMany(Address::class);
    }
    public function State(){
        return $this->belongsTo(State::class);
    }
}
