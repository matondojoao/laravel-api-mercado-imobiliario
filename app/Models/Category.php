<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RealState;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','description','slug'
    ];

    public function realstates(){
        return $this->belongsToMany(RealState::class,'real_state_categories');
    }
}
