<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model{
    public $timestamps = false;
    protected $table = 'billing';
    protected $primaryKey = 'id';

    protected $fillable = [
        'billing_id', 'created_at', 'date', 'status', 'amount'
    ];
}
