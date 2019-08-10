<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'seller';

    protected $fillable = ['user_id'];
}
