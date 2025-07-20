<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'date',
        'note',
        'deposit_amount',
        'expense_amount'
    ];
}
