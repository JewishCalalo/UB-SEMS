<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\EquipmentInstance;
use App\Models\ReservationItemInstance;
use Illuminate\Support\Facades\DB;

class FixReservationInstances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:fix-instances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing ReservationItemInstance records for existing reservations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fix missing reservation instances...');

        DB::beginTransaction();
        try {
            $reservations = Reservation::with(['items.equipment.instances'])->get();
            $fixedCount = 0;

            foreach ($reservations as $reservation) {
                foreach ($reservation->items as $item) {
                    // Check if this item already has instances
                    $existingInstances = ReservationItemInstance::where('reservation_item_id', $item->id)->count();
                    
                    if ($existingInstances === 0) {
                        // Get available instances for this equipment
                        $availableInstances = $item->equipment->instances()
                            ->where('is_active', true)
                            ->where('is_available', true)
                            ->take($item->quantity_approved ?: $item->quantity_requested)
                            ->get();

                        if ($availableInstances->count() > 0) {
                            foreach ($availableInstances as $instance) {
                                // Create the reservation item instance
                                ReservationItemInstance::create([
                                    'reservation_item_id' => $item->id,
                                    'equipment_instance_id' => $instance->id,
                                    'status' => in_array($reservation->status, ['picked_up', 'returned', 'overdue']) ? 'picked_up' : 'reserved',
                                    'picked_up_at' => in_array($reservation->status, ['picked_up', 'returned', 'overdue']) ? now() : null,
                                    'returned_at' => $reservation->status === 'returned' ? now() : null,
                                ]);

                                // Mark instance as unavailable if reservation is active
                                if (in_array($reservation->status, ['approved', 'picked_up', 'overdue'])) {
                                    $instance->update(['is_available' => false]);
                                }
                            }
                            
                            $fixedCount++;
                            $this->line("Fixed reservation item {$item->id} for reservation {$reservation->reservation_code}");
                        } else {
                            $this->warn("No available instances found for equipment {$item->equipment->name} in reservation {$reservation->reservation_code}");
                        }
                    }
                }
            }

            DB::commit();
            $this->info("Successfully fixed {$fixedCount} reservation items with missing instances!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error fixing reservation instances: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
