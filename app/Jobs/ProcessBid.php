<?php
// app/Jobs/ProcessBid.php
namespace App\Jobs;

use App\Models\AdSlot;
use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessBid implements ShouldQueue {
    use Dispatchable, Queueable;

    protected $userId, $slotId, $amount;

    public function __construct($userId, $slotId, $amount) {
        $this->userId = $userId;
        $this->slotId = $slotId;
        $this->amount = $amount;
    }

    public function handle() {
        $slot = AdSlot::findOrFail($this->slotId);
        if ($slot->status !== 'open' || $this->amount < $slot->min_bid_price) {
            return;
        }
        Bid::create([
            'user_id' => $this->userId,
            'ad_slot_id' => $this->slotId,
            'amount' => $this->amount,
        ]);
    }
}