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
        'payment_method',
        'payment_status',
        'transaction_id',
        'note', // 📝 tambahkan ini
    ];

    // Relasi: satu order memiliki banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: order milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
