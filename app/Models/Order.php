<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total',
        'note',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'total' => 'float',
    ];

    // Relasi ke item pesanan
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
