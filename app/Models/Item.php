<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "order_items";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'product_id', 'total'];

    /**
     * Get the Product related with this order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    /**
     * Get the Order related with this order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
