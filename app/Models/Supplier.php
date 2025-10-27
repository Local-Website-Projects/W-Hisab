<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'supplier_type',
        'supplier_phone',
        'supplier_address',
        'note',
    ];

    public function purchases()
    {
        return $this->hasMany(ProductPurchase::class, 'supplier_id');
    }

    public function flatsell()
    {
        return $this->hasMany(FlatSell::class, 'supplier_id');
    }

    public function payments()
    {
        return $this->hasMany(DebitCredits::class, 'supplier_id');
    }
}
