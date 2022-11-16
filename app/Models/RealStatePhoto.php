<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RealState;

class RealStatePhoto extends Model
{
    use HasFactory;

    protected $fillable=[
       'photo','is_thumb'
    ];
    protected $table='real_state_photos';
    
    public function realstate(){
        return $this->belongsTo(RealState::class);
    }
}
