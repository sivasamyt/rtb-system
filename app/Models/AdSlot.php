<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSlot extends Model
{
    protected $fillable = ['name', 'start_time', 'end_time', 'min_bid_price', 'status'];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'string',
    ];
    public function bids() {
        return $this->hasMany(Bid::class);
    }
    public function winner() {
        return $this->hasOne(Bid::class)->where('is_winner', true);
    }
}
