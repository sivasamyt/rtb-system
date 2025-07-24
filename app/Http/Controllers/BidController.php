<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ProcessBid;
use App\Models\AdSlot;
use App\Models\Bid;

class BidController extends Controller
{
    public function placeBid(Request $request, $slotId) {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $slot = AdSlot::findOrFail($slotId);
        if ($slot->status !== 'open') {
            return response()->json(['error' => 'Slot is not open'], 400);
        }
        if ($request->amount < $slot->min_bid_price) {
            return response()->json(['error' => 'Bid below minimum price'], 400);
        }

        ProcessBid::dispatch(auth()->id(), $slotId, $request->amount);
        return response()->json(['message' => 'Bid placed successfully']);
    }

    public function viewBids($slotId) {
        return Bid::where('ad_slot_id', $slotId)->with('user')->get();
    }

    public function viewWinner($slotId) {
        $slot = AdSlot::findOrFail($slotId);
        if ($slot->status !== 'awarded') {
            return response()->json(['error' => 'Slot not awarded'], 400);
        }
        return $slot->winner()->with('user')->first();
    }

    public function userBids() {
        return Bid::where('user_id', auth()->id())->with('adSlot')->get();
    }
}
