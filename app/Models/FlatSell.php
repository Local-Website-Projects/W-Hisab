<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlatSell extends Model
{
    protected $primaryKey = 'flat_sell_id';

    protected $fillable = [
        'supplier_id',
        'project_id',
        'total_amount',
        'date',
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
