<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model{
    public $timestamps = false;
    protected $table = 'subscribers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id', 'created_at', 'email', 'status', 'unsubscribe_at', 'cumulative _total_charged'
    ];
}
