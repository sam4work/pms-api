<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobileSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'msisdn','customer_id_owner','customer_id_user',
        'service_start_date','service_type'
    ];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id_owner','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id_user','id');
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('msisdn', 'like', '%'.$search.'%')->
            orWhere('service_type','like','%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
