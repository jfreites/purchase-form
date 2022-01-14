<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['total'];

    /**
     * Get the items for the Order.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
