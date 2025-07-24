<?php
// app/Console/Commands/UpdateSlotStatus.php
namespace App\Console\Commands;

use App\Models\AdSlot;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateSlotStatus extends Command {
    protected $signature = 'slots:update-status';
    protected $description = 'Update ad slot statuses based on start and end times';

    public function handle() {
        AdSlot::where('status', 'upcoming')
            ->where('start_time', '<=', Carbon::now())
            ->update(['status' => 'open']);

        AdSlot::where('status', 'open')
            ->where('end_time', '<=', Carbon::now())
            ->update(['status' => 'closed']);
    }
}