<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function show(Reservation $reservation)
    {
        $reservation->load([
            'user', 
            'createdBy',
            'items.equipment.category', 
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance', 
            'approvedBy'
        ]);
        
        return view('admin.reservations.show', compact('reservation'));
    }
}
