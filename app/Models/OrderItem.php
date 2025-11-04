<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
    ];

    // Relasi: item milik satu order
    public function order()
{
    return $this->belongsTo(Order::class);
}


    // Relasi: item berisi satu produk
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
