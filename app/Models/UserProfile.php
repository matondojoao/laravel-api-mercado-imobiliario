<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserProfile extends Model
{
    use HasFactory;

    protected $table='user_profile';
    
    protected $fillable=[
        'about','social_networks','phone','mobile_phone'
    ];

    public function user(){
        
       return $this->belongsTo(User::class);
    }
}
