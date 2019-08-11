<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intuit\Bid\BidType;

/**
 * Class Bid
 *
 * @property int project_id
 * @property int buyer_id
 * @property int type
 * @property float value
 * @property float|null hourly_value
 * @property int|null min_hours
 *
 * @package App
 */
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

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'value' => 'float',
        'hourly_value' => 'float',
    ];

    public function getBidValue(): float {
        if ($this->type == BidType::COST_FIXED) {
            return $this->value;

        } else { // $this->type == BidType::COST_HOURLY
            return $this->hourly_value * $this->min_hours;
        }
    }
}
