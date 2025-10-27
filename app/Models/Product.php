<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name'
    ];
    public function purchases()
    {
        return $this->hasMany(ProductPurchase::class);
    }

    public function payments()
    {
        return $this->hasMany(DebitCredit::class);
    }
}
