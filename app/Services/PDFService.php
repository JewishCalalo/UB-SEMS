<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class PDFService
{
    /**
     * Generate PDF for reservation management
     */
    public static function generateReservationReport($reservations, $filters = [])
    {
        $data = [
            'reservations' => $reservations,
            'filters' => $filters,
            'generated_at' => now()->format('F d, Y \a\t g:i A'),
            'title' => 'Reservation Management Report'
        ];

        $pdf = Pdf::loadView('pdf.reservation-report', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generate PDF for equipment management
     */
    public static function generateEquipmentReport($equipment, $filters = [])
    {
        try {
            $data = [
                'equipment' => $equipment,
                'filters' => $filters,
                'generated_at' => now()->format('F d, Y \a\t g:i A'),
                'title' => 'Equipment Management Report'
            ];

            $pdf = Pdf::loadView('pdf.equipment-report', $data);
            $pdf->setPaper('a4', 'landscape');
            
            return $pdf;
        } catch (\Exception $e) {
            \Log::error('PDFService Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate PDF for maintenance management
     */
    public static function generateMaintenanceReport($equipmentInstances, $maintenanceRecords, $filters = [])
    {
        $data = [
            'equipmentInstances' => $equipmentInstances,
            'maintenanceRecords' => $maintenanceRecords,
            'filters' => $filters,
            'generated_at' => now()->format('F d, Y \a\t g:i A'),
            'title' => 'Maintenance Management Report'
        ];

        $pdf = Pdf::loadView('pdf.maintenance-report', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generate PDF for wishlisted equipment
     */
    public static function generateWishlistedReport($equipment, $filters = [])
    {
        $data = [
            'equipment' => $equipment,
            'filters' => $filters,
            'generated_at' => now()->format('F d, Y \a\t g:i A'),
            'title' => 'Wishlisted Equipment Report'
        ];

        $pdf = Pdf::loadView('pdf.wishlisted-report', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf;
    }

    /**
     * Generate PDF for discarded equipment
     */
    public static function generateDiscardedReport($discardedItems, $filters = [])
    {
        $data = [
            'discardedItems' => $discardedItems,
            'filters' => $filters,
            'generated_at' => now()->format('F d, Y \a\t g:i A'),
            'title' => 'Discarded Equipment Report'
        ];

        $pdf = Pdf::loadView('pdf.discarded-report', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf;
    }
}
