<?php
// app/Console/Commands/EvaluateBids.php
namespace App\Console\Commands;

use App\Models\AdSlot;
use App\Models\Bid;
use Illuminate\Console\Command;

class EvaluateBids extends Command {
    protected $signature = 'bids:evaluate';
    protected $description = 'Evaluate bids and award winners';

    public function handle() {
        $slots = AdSlot::where('status', 'closed')->whereDoesntHave('winner')->get();
        foreach ($slots as $slot) {
            $winningBid = Bid::where('ad_slot_id', $slot->id)
                ->orderBy('amount', 'desc')
                ->orderBy('created_at', 'asc')
                ->first();
            if ($winningBid) {
                $winningBid->update(['is_winner' => true]);
                $slot->update(['status' => 'awarded']);
            }
        }
    }
}