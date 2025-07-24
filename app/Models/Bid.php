<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['user_id', 'ad_slot_id', 'amount', 'is_winner'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function adSlot() {
        return $this->belongsTo(AdSlot::class);
    }
}
