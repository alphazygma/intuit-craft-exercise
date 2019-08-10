<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyer';

    protected $fillable = ['user_id'];
}
