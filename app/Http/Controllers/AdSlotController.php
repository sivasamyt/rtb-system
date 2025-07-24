<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdSlot;


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
        $request->validate([
            'name' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'min_bid_price' => 'required|numeric|min:0',
        ]);

        return AdSlot::create($request->all());
    }
}
