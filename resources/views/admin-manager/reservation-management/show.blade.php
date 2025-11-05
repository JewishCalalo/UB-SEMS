<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservation #{{ $reservation->reservation_code }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Back Button -->
            <div class="mb-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('reservation-management.index') }}" 
                       class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-red-600 border-0 rounded-lg hover:bg-red-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Reservations
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Reservation #{{ $reservation->reservation_code }}
                        </h2>
                        <p class="text-sm text-gray-600">
                            Submitted on {{ $reservation->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                        @if($reservation->createdBy)
                            <p class="text-sm text-gray-600">Created by: <span class="font-medium">{{ $reservation->createdBy->name }}</span> ({{ ucfirst($reservation->createdBy->role) }})</p>
                        @elseif($reservation->user)
                            <p class="text-sm text-gray-600">Created by: <span class="font-medium">{{ $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User') }}</span> ({{ $reservation->user ? 'User' : 'Guest' }})</p>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                            'approved' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                            'denied' => 'bg-red-100 text-red-800 border border-red-200',
                            'picked_up' => 'bg-blue-100 text-blue-800 border border-blue-200',
                            'returned' => 'bg-purple-100 text-purple-800 border border-purple-200',
                            'completed' => 'bg-green-100 text-green-800 border border-green-200',
                            'overdue' => 'bg-red-100 text-red-800 border border-red-200',
                            'cancelled' => 'bg-gray-100 text-gray-600 border border-gray-200'
                        ];
                        $statusColor = $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }} shadow-sm">
                        {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                    </span>
                    @if($reservation->status === 'returned')
                        <div class="mt-2 text-xs text-gray-500">
                            Equipment returned, being processed
                        </div>
                    @elseif($reservation->status === 'completed')
                        <div class="mt-2 text-xs text-gray-500">
                            Reservation fully closed
                        </div>
                    @endif
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Borrower Info & Equipment -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Borrower/Teacher Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            @if($reservation->createdBy && !$reservation->user)
                                PE Staff Information
                            @else
                                Borrower Information
                            @endif
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="text-sm text-gray-900">{{ $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-sm text-gray-900">{{ $reservation->user ? $reservation->user->email : ($reservation->email ?? 'No email') }}</p>
                            </div>
                            
                            @if($reservation->createdBy && !$reservation->user)
                                <!-- PE Staff Reservation - Show creator info -->
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Reservation Created by</p>
                                    <p class="text-sm text-gray-900">{{ $reservation->createdBy->name }} ({{ ucfirst($reservation->createdBy->role) }})</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-sm font-medium text-gray-500">Reservation Type</p>
                                    <p class="text-sm text-blue-600 font-medium">PE Class Equipment Reservation</p>
                                </div>
                            @else
                                <!-- Guest/User Reservation - Show user details -->
                                @if($reservation->user && $reservation->user->contact_number)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Contact</p>
                                        <p class="text-sm text-gray-900">{{ $reservation->user->contact_number }}</p>
                                    </div>
                                @endif
                                @if($reservation->user && $reservation->user->department)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Department</p>
                                        <p class="text-sm text-gray-900">{{ $reservation->user->department }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Equipment Items -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            @php
                                $requestedHeaderCount = $reservation->items->sum(function($it){
                                    $requested = (int) ($it->quantity_requested ?? 0);
                                    $instances = method_exists($it, 'reservationItemInstances') ? $it->reservationItemInstances->count() : 0;
                                    return max($requested, $instances);
                                });
                            @endphp
                            Equipment Requested ({{ $requestedHeaderCount }} items)
                        </h3>
                        <div class="space-y-3">
                            @foreach($reservation->items as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->equipment->display_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->equipment->category->name }} • {{ $item->equipment->equipmentType->name ?? 'N/A' }}</p>
                                            @if($item->equipment->model)
                                                <p class="text-sm text-gray-500">{{ $item->equipment->model }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $requestedDisplay = max((int)($item->quantity_requested ?? 0), $item->reservationItemInstances?->count() ?? 0);
                                        @endphp
                                        <p class="font-medium text-gray-900">Requested: {{ $requestedDisplay }}</p>
                                        @if(!in_array($reservation->status, ['pending','cancelled','declined']))
                                            @if($item->quantity_approved > 0)
                                                <p class="text-sm text-green-600 font-medium">Approved: {{ $item->quantity_approved }}</p>
                                            @else
                                                <p class="text-sm text-red-600 font-medium">Declined (0 approved)</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Reserved Instances Information -->
                                @if($item->reservationItemInstances && $item->reservationItemInstances->count() > 0)
                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-sm font-medium text-blue-800">Reserved Instances ({{ $item->reservationItemInstances->count() }})</span>
                                            </div>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                                <thead class="bg-red-50">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Instance</th>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Status</th>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Pickup Condition</th>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Returned Condition</th>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-700 uppercase tracking-wider">Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    @foreach($item->reservationItemInstances as $reservationItemInstance)
                                                        @php
                                                            $instance = $reservationItemInstance->equipmentInstance;
                                                            $instanceStatus = $reservationItemInstance->status;
                                                            $pickedUpAt = $reservationItemInstance->picked_up_at;
                                                            $returnedAt = $reservationItemInstance->returned_at;
                                                            $instanceCode = $instance->instance_code ?: '#' . $instance->id;
                                                            
                                                            // Get return log for this instance
                                                            $returnLog = $instance->returnLogs()
                                                                ->where('reservation_id', $reservation->id)
                                                                ->first();
                                                        @endphp
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-3 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-gray-900">{{ $instanceCode }}</div>
                                                                @if($instance->serial_number)
                                                                    <div class="text-sm text-gray-500">{{ $instance->serial_number }}</div>
                                                                @endif
                                                                @if($instance->location)
                                                                    <div class="text-xs text-blue-600">{{ $instance->location }}</div>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-4 whitespace-nowrap">
                                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                                    @if($instanceStatus === 'reserved') bg-yellow-100 text-yellow-800
                                                                    @elseif($instanceStatus === 'picked_up') bg-blue-100 text-blue-800
                                                                    @elseif($instanceStatus === 'returned') bg-green-100 text-green-800
                                                                    @else bg-gray-100 text-gray-800 @endif">
                                                                    {{ ucfirst($instanceStatus) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-3 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                                @if($pickedUpAt)
                                                                    @php
                                                                        $pickupCondition = $reservationItemInstance->pickup_condition ?? $reservationItemInstance->equipmentInstance->condition;
                                                                    @endphp
                                                                    <div class="font-bold">{{ ucfirst(str_replace('_', ' ', $pickupCondition)) }}</div>
                                                                    <div class="text-xs font-medium text-gray-700">{{ \Carbon\Carbon::parse($pickedUpAt)->format('M d, Y g:i A') }}</div>
                                                                @else
                                                                    <span class="text-gray-400">Not picked up</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                @if($returnedAt && $returnLog)
                                                                    <div class="font-medium">{{ ucfirst(str_replace('_', ' ', $returnLog->returned_condition)) }}</div>
                                                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($returnedAt)->format('M d, Y g:i A') }}</div>
                                                                @elseif($returnedAt)
                                                                    <div class="font-medium">Good</div>
                                                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($returnedAt)->format('M d, Y g:i A') }}</div>
                                                                @else
                                                                    <span class="text-gray-400">Not returned</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-4 text-sm text-gray-900 align-top whitespace-normal break-words max-w-[28rem]">
                                                                <div class="space-y-1">
                                                                    @if(!empty($reservationItemInstance->pickup_notes))
                                                                        <div class="text-xs text-blue-600">Pickup: {{ $reservationItemInstance->pickup_notes }}</div>
                                                                    @endif
                                                                    @if($returnLog && !empty($returnLog->condition_notes))
                                                                        <div class="text-xs text-purple-600">Return: {{ $returnLog->condition_notes }}</div>
                                                                    @endif
                                                                    @if($returnLog && !empty($returnLog->damage_description))
                                                                        <div class="text-xs text-red-600">Warning: {{ $returnLog->damage_description }}</div>
                                                                    @endif
                                                                    @if(empty($reservationItemInstance->pickup_notes) && (!$returnLog || empty($returnLog->condition_notes)) && (!$returnLog || empty($returnLog->damage_description)))
                                                                        <span class="text-gray-400 text-xs">No notes</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <!-- Show message when no instances are assigned for approved items -->
                                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-yellow-800">No instances assigned yet</span>
                                        </div>
                                        <p class="text-xs text-yellow-700 mt-1">This equipment item has no specific instances assigned to this reservation.</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details & Timeline -->
                <div class="space-y-6">
                    <!-- Reservation Details -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8l-2-2m0 0l2-2m-2 2h12"></path>
                            </svg>
                            Reservation Details
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Borrow Date</p>
                                <p class="text-sm text-gray-900">{{ $reservation->borrow_date->format('M d, Y') }}
                                    @if($reservation->borrow_time)
                                        at {{ \Carbon\Carbon::parse($reservation->borrow_time)->format('g:i A') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Return Date</p>
                                <p class="text-sm text-gray-900">{{ $reservation->return_date->format('M d, Y') }}
                                    @if($reservation->return_time)
                                        at {{ \Carbon\Carbon::parse($reservation->return_time)->format('g:i A') }}
                                    @endif
                                </p>
                            </div>
                            
                            @if($reservation->createdBy && !$reservation->user)
                                <!-- PE Staff Reservation Details -->
                                @if($reservation->remarks)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Class/Activity Notes</p>
                                        <p class="text-sm text-gray-900">{{ $reservation->remarks }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Reservation Type</p>
                                    <p class="text-sm text-blue-600 font-medium">PE Class Equipment</p>
                                </div>
                            @else
                                <!-- Guest/User Reservation Details -->
                                @if($reservation->reason)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Reason</p>
                                        <p class="text-sm text-gray-900">{{ $reservation->reason }}</p>
                                    </div>
                                @endif
                                @if($reservation->additional_details)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Additional Details</p>
                                        <p class="text-sm text-gray-900">{{ $reservation->additional_details }}</p>
                                    </div>
                                @endif
                                @if($reservation->remarks)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Remarks</p>
                                        <p class="text-sm text-gray-900">{{ $reservation->remarks }}</p>
                                    </div>
                                @endif
                            @endif
                            
                            <!-- Additional Reservation Information -->
                            @if($reservation->pickup_date)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Scheduled Pickup Date</p>
                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y') }}</p>
                                </div>
                            @endif
                            
                            @if($reservation->approved_by)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Approved By</p>
                                    <p class="text-sm text-gray-900">{{ $reservation->approvedBy->name ?? 'Unknown' }} ({{ ucfirst($reservation->approvedBy->role ?? 'Staff') }})</p>
                                </div>
                            @endif
                            
                            @if($reservation->picked_up_at)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Picked Up At</p>
                                    <p class="text-sm text-gray-900">{{ $reservation->picked_up_at->format('M d, Y g:i A') }}</p>
                                </div>
                            @endif
                            
                            @if($reservation->returned_at)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Returned At</p>
                                    <p class="text-sm text-gray-900">{{ $reservation->returned_at->format('M d, Y g:i A') }}</p>
                                </div>
                            @endif
                            
                            @if($reservation->completed_at)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Completed At</p>
                                    <p class="text-sm text-gray-900">{{ $reservation->completed_at->format('M d, Y g:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Comprehensive Notes & Remarks Section -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Notes & Remarks
                        </h3>
                        <div class="space-y-4">
                            @if($reservation->reason)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-green-800 mb-2">Reason for Reservation</h4>
                                    <p class="text-sm text-green-700">{{ $reservation->reason }}</p>
                                </div>
                            @endif

                            @if($reservation->additional_details)
                                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-purple-800 mb-2">Additional Details</h4>
                                    <p class="text-sm text-purple-700">{{ $reservation->additional_details }}</p>
                                </div>
                            @endif

                            @if($reservation->status === 'cancelled' && $reservation->remarks)
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-red-800 mb-2">Cancellation Remarks</h4>
                                    <p class="text-sm text-red-700">{{ $reservation->remarks }}</p>
                                </div>
                            @elseif($reservation->status === 'denied' && $reservation->remarks)
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-orange-800 mb-2">Decline Remarks</h4>
                                    <p class="text-sm text-orange-700">{{ $reservation->remarks }}</p>
                                </div>
                            @elseif($reservation->remarks)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-blue-800 mb-2">Reservation Remarks</h4>
                                    <p class="text-sm text-blue-700">{{ $reservation->remarks }}</p>
                                </div>
                            @endif

                            @if(!$reservation->remarks && !$reservation->reason && !$reservation->additional_details)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-500 italic">No additional notes or remarks recorded for this reservation.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status Timeline
                        </h3>
                        <div class="space-y-4">
                            <!-- Reservation Submitted - Always shown -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mt-2"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        @if($reservation->createdBy && !$reservation->user)
                                            PE Staff Reservation Created by {{ $reservation->createdBy->name }} ({{ ucfirst($reservation->createdBy->role) }})
                                        @elseif($reservation->createdBy)
                                            Reservation Created by {{ $reservation->createdBy->name }} ({{ ucfirst($reservation->createdBy->role) }})
                                        @else
                                            Reservation Submitted
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $reservation->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>

                            <!-- Approval - Show if approved_at exists -->
                            @if($reservation->approved_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-green-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Approved @if($reservation->approvedBy) by {{ $reservation->approvedBy->name }} @endif</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->approved_at->format('M d, Y g:i A') }}</p>
                                        @if($reservation->remarks)
                                            <p class="text-sm text-gray-600 mt-1">{{ $reservation->remarks }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Denied - Show if status is denied -->
                            @if($reservation->status === 'denied')
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-red-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Denied @if($reservation->approvedBy) by {{ $reservation->approvedBy->name }} @endif</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->approved_at ? $reservation->approved_at->format('M d, Y g:i A') : '—' }}</p>
                                        @if($reservation->remarks)
                                            <p class="text-sm text-gray-600 mt-1">{{ $reservation->remarks }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Scheduled Pickup - from pickup_date (planned) -->
                            @if($reservation->pickup_date && in_array($reservation->status, ['approved', 'picked_up', 'returned', 'completed']))
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Scheduled Pickup</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->pickup_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Actual Pickup - from picked_up_at (actual) -->
                            @if($reservation->picked_up_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Actual Pickup</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->picked_up_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Actual Return - from returned_at (actual) -->
                            @if($reservation->returned_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-purple-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Actual Return</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->returned_at->format('M d, Y g:i A') }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Equipment has been returned and is being processed</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Reservation Completed - Show if status is completed -->
                            @if($reservation->status === 'completed')
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-green-600 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Completed</p>
                                        <p class="text-sm text-gray-600">All equipment processed and returned</p>
                                        <p class="text-xs text-gray-500 mt-1">This reservation is now fully closed</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Cancelled - Show if status is cancelled -->
                            @if($reservation->status === 'cancelled')
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-red-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Cancelled</p>
                                        <p class="text-sm text-gray-600">
                                            @if($reservation->cancelled_at)
                                                {{ $reservation->cancelled_at->format('M d, Y g:i A') }}
                                            @else
                                                Cancelled
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions removed per requirement -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function showImageModal(src) {
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.inset = '0';
        overlay.style.background = 'rgba(0,0,0,0.75)';
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';
        overlay.style.zIndex = '9999';
        
        const img = document.createElement('img');
        img.src = src;
        img.style.maxWidth = '90%';
        img.style.maxHeight = '90%';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 10px 30px rgba(0,0,0,0.5)';

        overlay.appendChild(img);
        document.body.appendChild(overlay);
        
        overlay.addEventListener('click', () => {
            overlay.remove();
        });
        document.addEventListener('keydown', function esc(e){
            if (e.key === 'Escape') {
                overlay.remove();
                document.removeEventListener('keydown', esc);
            }
        });
    }
</script>
