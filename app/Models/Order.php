<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'currency',
        'status',
        'payment_provider',
        'provider_ref',
        'meta',
        'paid_at',
    ];

    protected $casts = [
        'meta'    => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
