<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GhanaCard extends Model
{
    use HasFactory;


    protected $fillable = [
        "pin"
    ];



    public function owners(){
        return $this->hasMany(MobileSubscriber::class);
    }
    public function users(){
        return $this->hasMany(MobileSubscriber::class);
    }
}
