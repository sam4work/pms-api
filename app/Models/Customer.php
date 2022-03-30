<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        "first_name","last_name"
    ];



    public function owners(){
        return $this->hasMany(MobileSubscriber::class,'customer_id_owner');
    }
    public function users(){
        return $this->hasMany(MobileSubscriber::class,'customer_id_user');
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('first_name', 'like', '%'.$search.'%')->
            orWhere('last_name','like','%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
