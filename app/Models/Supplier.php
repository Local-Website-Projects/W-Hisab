<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'supplier_phone',
        'supplier_address',
        'note',
    ];
}
