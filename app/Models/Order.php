<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    // Визначаємо зв'язок з користувачем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Визначаємо зв'язок з товаром через OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
