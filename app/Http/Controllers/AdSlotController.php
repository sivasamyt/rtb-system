<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdSlot;
use Carbon\Carbon;


class AdSlotController extends Controller
{
    public function index(Request $request) {
        $query = AdSlot::query();
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        return $query->get();
    }

    public function store(Request $request) {
        $now = Carbon::now();
        $request->validate([
            'name' => 'required|string',
            'start_time' => ['required', 'date', 'after:' . $now],
            'end_time' => ['required', 'date', 'after:start_time'],
            'min_bid_price' => 'required|numeric|min:0',
        ], [
            'start_time.after' => 'Start time must be in the future.',
            'end_time.after' => 'End time must be after the start time.',
        ]);

        return AdSlot::create($request->all());
    }
}
