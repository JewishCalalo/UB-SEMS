<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\Wishlist;
use App\Models\MaintenanceRecord;
use App\Models\ReservationItem;
use App\Models\EquipmentImage;

class CleanupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:cleanup {--force : Force the cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all data except admin and manager accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Show current data counts
        $this->info('Current data counts:');
        $this->table(
            ['Model', 'Count'],
            [
                ['Users', User::count()],
                ['Reservations', Reservation::count()],
                ['Equipment', Equipment::count()],
                ['Equipment Categories', EquipmentCategory::count()],
                ['Wishlists', Wishlist::count()],
                ['Maintenance Records', MaintenanceRecord::count()],
                ['Reservation Items', ReservationItem::count()],
                ['Equipment Images', EquipmentImage::count()],
            ]
        );

        // Show admin and manager users that will be preserved
        $adminUsers = User::whereIn('role', ['admin', 'manager'])->get();
        $this->info('Admin and Manager accounts that will be preserved:');
        $this->table(
            ['ID', 'Name', 'Email', 'Role'],
            $adminUsers->map(function ($user) {
                return [$user->id, $user->name, $user->email, $user->role];
            })->toArray()
        );

        // Confirm cleanup
        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete all data except admin and manager accounts?')) {
                $this->info('Cleanup cancelled.');
                return;
            }
        }

        $this->info('Starting cleanup...');

        // Delete data in the correct order to avoid foreign key constraints
        $this->info('Deleting wishlists...');
        Wishlist::truncate();

        $this->info('Deleting reservation items...');
        ReservationItem::truncate();

        $this->info('Deleting reservations...');
        Reservation::truncate();

        $this->info('Deleting maintenance records...');
        MaintenanceRecord::truncate();

        $this->info('Deleting equipment images...');
        EquipmentImage::truncate();

        $this->info('Deleting equipment...');
        Equipment::truncate();

        $this->info('Deleting equipment categories...');
        EquipmentCategory::truncate();

        // Delete regular users (not admin/manager)
        $this->info('Deleting regular user accounts...');
        User::whereNotIn('role', ['admin', 'manager'])->delete();

        $this->info('Cleanup completed successfully!');
        $this->info('Admin and Manager accounts have been preserved.');
    }
}
