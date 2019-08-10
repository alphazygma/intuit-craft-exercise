<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

    protected $fillable = [
        'title',
        'description',
        'seller_id',
        'status',
        'deadline_at',
        'lowest_bid_id',
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
    ];

    protected $hidden = [
        'updated_at'
    ];
}
