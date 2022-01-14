<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Get the items for a Product.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
