<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bid';

    protected $fillable = [
        'project_id',
        'buyer_id',
        'type',
        'value',
        'hourly_value',
        'min_hours',7
    ];
}
