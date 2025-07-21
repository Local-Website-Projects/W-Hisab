<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitCredits extends Model
{
    protected $primaryKey = 'debit_credit_id';
    protected $fillable = [
        'project_id',
        'supplier_id',
        'product_id',
        'note',
        'debit',
        'credit',
    ];

    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_id', 'project_id');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'product_id');
    }


}
