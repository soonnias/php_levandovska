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
        'delivery_address',
        'customer_name',
        'customer_surname',
        'customer_phone',
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

    /**
     * @param string[] $fillable
     * @return Order
     */
    public function setFillable(array $fillable): Order
    {
        $this->fillable = $fillable;
        return $this;
    }
}
