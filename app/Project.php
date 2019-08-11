<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 *
 * @property string title
 * @property string description
 * @property int seller_id
 * @property int status
 * @property int deadline_at
 * @property int lowest_bid_id
 *
 * @package App
 */
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
        'deadline_at' => 'timestamp',
        'created_at'  => 'timestamp',
    ];

    protected $hidden = [
        'updated_at'
    ];
}
