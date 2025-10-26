<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $primaryKey = 'product_purchase_id';
    protected $fillable = [
        'product_id',
        'supplier_id',
        'project_id',
        'quantity',
        'unit',
        'unit_price',
        'total_price',
        'note',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
