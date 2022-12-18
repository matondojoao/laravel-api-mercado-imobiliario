<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\RealStatePhoto;
use App\Model\Address;

class RealState extends Model
{
    use HasFactory;

    protected $fillable=[
        'title','description','content',
        'price','bathrooms','bedrooms',
        'property_area','total_property_area',
        'slug','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'real_state_categories');
    }

    public function photos(){
        return $this->hasMany(RealStatePhoto::class);
    }
    public function Addresses(){
        return $this->belongsTo(Address::class);
    }

}
