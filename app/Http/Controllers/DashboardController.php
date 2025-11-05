<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\User;
use App\Models\MaintenanceRecord;
use App\Models\Wishlist;
use App\Models\MissingEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            
            // If no user is authenticated, redirect to login
            if (!$user) {
                return redirect()->route('login');
            }
            
            if ($user->isAdmin()) {
                return $this->adminDashboard();
            } elseif ($user->isManager()) {
                return $this->managerDashboard();
            } elseif ($user->isInstructor()) {
                return redirect()->route('instructor.dashboard');
            } else {
                return $this->userDashboard();
            }
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage() . ' at line ' . $e->getLine() . ' in ' . $e->getFile());
            return redirect()->route('welcome')->with('error', 'Unable to load dashboard. Please try again. Error: ' . $e->getMessage());
        }
    }

    private function adminDashboard()
    {
        // Equipment statistics - now based on instances
        $totalEquipment = Equipment::count();
        $totalInstances = \App\Models\EquipmentInstance::count();
        $availableInstances = \App\Models\EquipmentInstance::where('is_available', true)->where('is_active', true)->count();
        $unavailableInstances = \App\Models\EquipmentInstance::where('is_available', false)->where('is_active', true)->count();
        $damagedInstances = \App\Models\EquipmentInstance::where('condition', 'damaged')->where('is_active', true)->count();
        $lostInstances = \App\Models\EquipmentInstance::where('condition', 'lost')->where('is_active', true)->count();
        $instancesNeedingMaintenance = \App\Models\EquipmentInstance::where('condition', 'needs_repair')->where('is_active', true)->count();
        
        // Stolen/Lost Equipment statistics
        $stolenLostEquipment = \App\Models\MissingEquipment::count();
        
        // Equipment Lifecycle Analytics
        $retiredInstances = \App\Models\EquipmentInstance::where('is_active', false)->count();
        $instancesInMaintenance = \App\Models\EquipmentInstance::where('condition', 'needs_repair')->where('is_active', true)->count();
        $instancesWithMaintenanceHistory = \App\Models\MaintenanceRecord::count(); // Simplified for now
        $instancesWithoutMaintenanceHistory = $totalInstances - $instancesWithMaintenanceHistory;
        
        // Calculate lifecycle percentages
        $lifecycleData = [
            'Active' => $availableInstances + $unavailableInstances,
            'Retired' => $retiredInstances,
            'Missing' => $stolenLostEquipment,
            'In Maintenance' => $instancesInMaintenance
        ];

        // Reservation statistics
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $approvedReservations = Reservation::where('status', 'approved')->count();
        $pickedUpReservations = Reservation::where('status', 'picked_up')->count();
        $returnedReservations = Reservation::where('status', 'returned')->count();
        $overdueReservations = Reservation::where('status', 'picked_up')
            ->where('return_date', '<', now())
            ->count();
        $completedReservations = Reservation::where('status', 'returned')->count();

        // User statistics
        $totalUsers = User::count();
        $activeUsers = User::where('created_at', '>=', now()->subDays(30))->count();

        // Equipment by category with instance counts - optimized with caching
        $equipmentByCategory = cache()->remember('dashboard_equipment_by_category', 1800, function() {
            return DB::table('equipment')
                ->join('equipment_categories', 'equipment.category_id', '=', 'equipment_categories.id')
                ->leftJoin('equipment_instances', 'equipment.id', '=', 'equipment_instances.equipment_id')
                ->select(
                    'equipment_categories.name',
                    DB::raw('COUNT(DISTINCT equipment.id) as equipment_count'),
                    DB::raw('COUNT(equipment_instances.id) as instance_count')
                )
                ->groupBy('equipment_categories.id', 'equipment_categories.name')
                ->get();
        });

        // Monthly reservation trends for the last 6 months (continuous months)
        $driver = DB::getDriverName();
        $monthExpression = match ($driver) {
            'sqlite' => "strftime('%Y-%m', created_at)",
            'pgsql' => "to_char(created_at, 'YYYY-MM')",
            default => "DATE_FORMAT(created_at, '%Y-%m')", // MySQL / MariaDB
        };

        $monthlyReservationsRaw = DB::table('reservations')
            ->select(DB::raw("$monthExpression as month"), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Ensure all last 6 months are present with zeroes if missing
        $monthlyReservationsMap = $monthlyReservationsRaw->pluck('count', 'month');
        $monthlyReservations = collect();
        $startMonth = now()->copy()->startOfMonth()->subMonths(5);
        for ($i = 0; $i < 6; $i++) {
            $monthKey = $startMonth->copy()->addMonths($i)->format('Y-m');
            $monthlyReservations->push([
                'month' => $monthKey,
                'count' => (int) ($monthlyReservationsMap[$monthKey] ?? 0),
            ]);
        }
        // Convert to collection of objects for view compatibility
        $monthlyReservations = $monthlyReservations->map(function ($row) {
            return (object) $row;
        });

        // Equipment status distribution for pie chart
        $equipmentStatusData = [
            'Available' => $availableInstances,
            'Unavailable' => $unavailableInstances,
            'Damaged' => $damagedInstances,
            'Needs Repair' => $instancesNeedingMaintenance,
            'Lost' => $lostInstances
        ];

        // Top borrowed equipment (by instances)
        $topBorrowed = DB::table('reservation_item_instances')
            ->join('equipment_instances', 'reservation_item_instances.equipment_instance_id', '=', 'equipment_instances.id')
            ->join('equipment', 'equipment_instances.equipment_id', '=', 'equipment.id')
            ->select('equipment.brand', 'equipment.model', DB::raw('COUNT(*) as total_borrowed'))
            ->groupBy('equipment.id', 'equipment.brand', 'equipment.model')
            ->orderBy('total_borrowed', 'desc')
            ->limit(8)
            ->get();

        // Recent reservations
        $recentReservations = Reservation::with('user', 'items.equipment')
            ->latest()
            ->limit(5)
            ->get();

        // Overdue tracking
        $overdueTracking = Reservation::where('status', 'picked_up')
            ->where('return_date', '<', now())
            ->with(['user', 'items.equipment'])
            ->orderBy('return_date', 'asc')
            ->limit(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalEquipment',
            'totalInstances',
            'availableInstances',
            'unavailableInstances',
            'damagedInstances',
            'lostInstances',
            'instancesNeedingMaintenance',
            'stolenLostEquipment',
            'retiredInstances',
            'instancesInMaintenance',
            'instancesWithMaintenanceHistory',
            'instancesWithoutMaintenanceHistory',
            'lifecycleData',
            'totalReservations',
            'pendingReservations',
            'approvedReservations',
            'pickedUpReservations',
            'returnedReservations',
            'overdueReservations',
            'completedReservations',
            'totalUsers',
            'activeUsers',
            'equipmentByCategory',
            'monthlyReservations',
            'equipmentStatusData',
            'topBorrowed',
            'recentReservations',
            'overdueTracking'
        ));
    }

    private function managerDashboard()
    {
        // Equipment statistics for managers - now based on instances
        $totalEquipment = Equipment::count();
        $totalInstances = \App\Models\EquipmentInstance::count();
        $availableInstances = \App\Models\EquipmentInstance::where('is_available', true)->where('is_active', true)->count();
        $instancesNeedingMaintenance = \App\Models\EquipmentInstance::where('condition', 'needs_repair')->where('is_active', true)->count();
        $damagedInstances = \App\Models\EquipmentInstance::where('condition', 'damaged')->where('is_active', true)->count();
        $lostInstances = \App\Models\EquipmentInstance::where('condition', 'lost')->where('is_active', true)->count();
        $unavailableInstances = \App\Models\EquipmentInstance::where('is_available', false)->where('is_active', true)->count();
        
        // Stolen/Lost Equipment statistics
        $stolenLostEquipment = \App\Models\MissingEquipment::count();

        // Maintenance statistics
        $instancesWithMaintenanceHistory = \App\Models\MaintenanceRecord::count(); // Simplified for now
        $instancesWithoutMaintenanceHistory = $totalInstances - $instancesWithMaintenanceHistory;
        $retiredInstances = \App\Models\EquipmentInstance::where('is_active', false)->count();
        $instancesInMaintenance = \App\Models\EquipmentInstance::where('condition', 'needs_repair')->where('is_active', true)->count();
        
        // Calculate completion rate (available instances / total instances)
        $completionRate = $totalInstances > 0 ? round(($availableInstances / $totalInstances) * 100) : 0;

        // Reservation statistics
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $approvedReservations = Reservation::where('status', 'approved')->count();
        $overdueReservations = Reservation::where('status', 'picked_up')
            ->where('return_date', '<', now())
            ->count();

        // Recent reservations
        $recentReservations = Reservation::with('user', 'items.equipment')
            ->latest()
            ->limit(5)
            ->get();

        // Equipment needing maintenance
        $maintenanceNeeded = \App\Models\EquipmentInstance::where('condition', 'needs_repair')
            ->where('is_active', true)
            ->with('equipment.category')
            ->get();

        // Equipment by category with instance counts - optimized with caching
        $equipmentByCategory = cache()->remember('dashboard_equipment_by_category_manager', 1800, function() {
            return DB::table('equipment')
                ->join('equipment_categories', 'equipment.category_id', '=', 'equipment_categories.id')
                ->leftJoin('equipment_instances', 'equipment.id', '=', 'equipment_instances.equipment_id')
                ->select(
                    'equipment_categories.name',
                    DB::raw('COUNT(DISTINCT equipment.id) as equipment_count'),
                    DB::raw('COUNT(equipment_instances.id) as instance_count')
                )
                ->groupBy('equipment_categories.id', 'equipment_categories.name')
                ->get();
        });

        // Monthly reservation trends for the last 6 months (continuous months)
        $monthlyReservations = cache()->remember('dashboard_monthly_reservations_manager', 1800, function() {
            $driver = DB::getDriverName();
            $monthExpression = match ($driver) {
                'sqlite' => "strftime('%Y-%m', created_at)",
                'pgsql' => "to_char(created_at, 'YYYY-MM')",
                default => "DATE_FORMAT(created_at, '%Y-%m')", // MySQL / MariaDB
            };
            
            return Reservation::selectRaw("$monthExpression as month, COUNT(*) as count")
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->get();
        });

        // Top borrowed equipment (by instances)
        $topBorrowed = DB::table('reservation_item_instances')
            ->join('equipment_instances', 'reservation_item_instances.equipment_instance_id', '=', 'equipment_instances.id')
            ->join('equipment', 'equipment_instances.equipment_id', '=', 'equipment.id')
            ->select('equipment.brand', 'equipment.model', DB::raw('COUNT(*) as total_borrowed'))
            ->groupBy('equipment.id', 'equipment.brand', 'equipment.model')
            ->orderBy('total_borrowed', 'desc')
            ->limit(8)
            ->get();

        // Overdue tracking
        $overdueTracking = Reservation::where('status', 'picked_up')
            ->where('return_date', '<', now())
            ->with(['user', 'items.equipment'])
            ->orderBy('return_date', 'asc')
            ->limit(10)
            ->get();

        // Equipment status distribution for manager pie chart
        $equipmentStatusData = [
            'Available' => $availableInstances,
            'Unavailable' => $unavailableInstances,
            'Damaged' => $damagedInstances,
            'Needs Repair' => $instancesNeedingMaintenance,
            'Lost' => $lostInstances,
        ];

        // Lifecycle data for charts/cards
        $lifecycleData = [
            'Active' => $availableInstances + $unavailableInstances,
            'Retired' => $retiredInstances,
            'Missing' => $stolenLostEquipment,
            'In Maintenance' => $instancesInMaintenance,
        ];

        return view('manager.dashboard.index', compact(
            'totalEquipment',
            'totalInstances',
            'availableInstances',
            'unavailableInstances',
            'instancesNeedingMaintenance',
            'damagedInstances',
            'lostInstances',
            'stolenLostEquipment',
            'retiredInstances',
            'instancesInMaintenance',
            'instancesWithMaintenanceHistory',
            'instancesWithoutMaintenanceHistory',
            'completionRate',
            'pendingReservations',
            'approvedReservations',
            'overdueReservations',
            'recentReservations',
            'maintenanceNeeded',
            'equipmentByCategory',
            'monthlyReservations',
            'lifecycleData',
            'equipmentStatusData',
            'topBorrowed',
            'overdueTracking'
        ));
    }

    private function userDashboard()
    {
        $user = auth()->user();
        
        // User's reservations
        $userReservations = $user->reservations()
            ->with('items.equipment')
            ->latest()
            ->limit(5)
            ->get();

        // Active reservations count
        $activeReservations = $user->reservations()
            ->whereIn('status', ['pending', 'approved', 'picked_up'])
            ->count();

        // Completed reservations count
        $completedReservations = $user->reservations()
            ->where('status', 'returned')
            ->count();

        // Recent equipment
        $recentEquipment = Equipment::where('is_active', true)
            ->with(['category', 'instances'])
            ->get()
            ->filter(function($equipment) {
                return $equipment->quantity_available > 0;
            })
            ->take(6);

        return view('user.dashboard.index', compact(
            'userReservations',
            'activeReservations',
            'completedReservations',
            'recentEquipment'
        ));
    }
}
