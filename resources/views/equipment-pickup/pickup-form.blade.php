<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipment Pickup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Reservation Management', 'url' => route('reservation-management.index')],
                ['label' => 'Equipment Pickup']
            ]" />

            <!-- Success/Error Messages kept minimal for users -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Header with Create Button and Quick Actions -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Process Equipment Pickup</h3>
                        <p class="text-gray-600">Select specific instances and record their pickup condition for this reservation</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('reservation-management.index') }}" 
                                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Reservations
                </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Reservation Information -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Reservation Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Reservation Code</p>
                                <p class="text-sm text-gray-900">{{ $reservation->reservation_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">User</p>
                                <p class="text-sm text-gray-900">
                                    {{ $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="text-sm text-gray-900">
                                    {{ $reservation->user ? $reservation->user->email : ($reservation->email ?? 'N/A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Borrow Date</p>
                                <p class="text-sm text-gray-900">{{ $reservation->borrow_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Return Date</p>
                                <p class="text-sm text-gray-900">{{ $reservation->return_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pickup Date</p>
                                <p class="text-sm text-gray-900">{{ $reservation->pickup_date ? $reservation->pickup_date->format('M d, Y') : 'Not set' }}</p>
                            </div>
                        </div>
                    </div>

        <form method="POST" action="{{ route('equipment-pickup.process', $reservation) }}" class="space-y-8">
            @csrf
            
            @if($errors->any())
                <div class="mb-6 -mt-2">
                    <div class="bg-red-50 border border-red-200 rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2">
                            <h4 class="text-sm font-bold">We need a few fixes before you can proceed</h4>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-700 mb-2">Please check the highlighted fields below. Common issues:</p>
                                    <ul class="list-disc pl-5 text-sm text-gray-800 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ Str::of($error)->replace(['pickup_conditions.'], 'Pickup condition for item #') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
                    <!-- Equipment Pickup Form -->
                    <form method="POST" action="{{ route('equipment-pickup.process', $reservation) }}" class="space-y-6" novalidate>
                        @csrf
                        
                        <div class="mb-8">
                            <!-- Equipment Pickup Table Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">Equipment Pickup Details</h3>
                                <p class="text-sm text-gray-600 mt-1">Select specific instances and record their pickup condition for each equipment item</p>
                            </div>
                
                @if($reservation->items->count() > 0)
                    <!-- Individual Equipment Tables -->
                    <div class="space-y-8">
                        @foreach($reservation->items as $item)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                <!-- Equipment Header -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($item->equipment->images->count() > 0)
                                                <img class="h-12 w-12 rounded-lg object-cover mr-4" 
                                                     src="{{ $item->equipment->images->first()->url }}" 
                                                     alt="{{ $item->equipment->name }}"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                     onload="this.style.display='block';">
                                                <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center mr-4" style="display: none;">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900">{{ $item->equipment->name }}</h4>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <span class="text-sm font-medium text-gray-700">{{ $item->equipment->brand ?: 'No brand' }}</span>
                                                    <span class="text-sm text-gray-500">{{ $item->equipment->model ?: 'No model' }}</span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $item->equipment->category->name }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $item->equipment->equipmentType->name ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->quantity_approved }} item{{ $item->quantity_approved > 1 ? 's' : '' }}</div>
                                            <div class="text-xs text-gray-500">to pickup</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Equipment Instances Table -->
                                <div class="p-6">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-blue-600">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Select Instance</th>
                                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @for($i = 0; $i < $item->quantity_approved; $i++)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <select name="equipment_instances[{{ $item->id }}][{{ $i }}]" 
                                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                required>
                                                            @php
                                                                // Get the specific assigned instance for this row (index $i)
                                                                $assignedInstances = $item->reservationItemInstances->sortBy('id');
                                                                $currentRowAssignedInstance = $assignedInstances->skip($i)->first();
                                                                $currentRowInstanceId = $currentRowAssignedInstance ? $currentRowAssignedInstance->equipment_instance_id : null;
                                                                
                                                                // Get all available instances for selection
                                                                $allInstances = $item->equipment->instances;
                                                                $assignedInstanceIds = $assignedInstances->pluck('equipment_instance_id')->toArray();
                                                                
                                                                // Filter instances: include assigned ones + available ones
                                                                $selectableInstances = $allInstances->filter(function($instance) use ($assignedInstanceIds) {
                                                                    $isAssigned = in_array($instance->id, $assignedInstanceIds);
                                                                    $badCondition = in_array($instance->condition, ['damaged', 'needs_repair', 'lost', 'under_maintenance']);
                                                                    return $isAssigned || ($instance->is_active && $instance->is_available && !$badCondition);
                                                                });
                                                            @endphp
                                                            
                                                            <option value="">Select instance...</option>
                                                            @if($selectableInstances->count() > 0)
                                                                @foreach($selectableInstances as $instance)
                                                                    @php
                                                                        $isAssigned = in_array($instance->id, $assignedInstanceIds);
                                                                        $isCurrentRowAssigned = ($instance->id == $currentRowInstanceId);
                                                                        $isDisabled = !$isAssigned && (!$instance->is_active || !$instance->is_available);
                                                                        $shouldSelect = $isCurrentRowAssigned;
                                                                    @endphp
                                                                    <option value="{{ $instance->id }}" {{ $shouldSelect ? 'selected' : '' }} {{ $isDisabled ? 'disabled' : '' }}>
                                                                        {{ $instance->instance_code ?: 'Instance #' . $instance->id }} 
                                                                        ({{ ucfirst($instance->condition) }})
                                                                        @if($isCurrentRowAssigned)
                                                                            — Currently Assigned
                                                                        @elseif($isAssigned)
                                                                            — Assigned to Other Row
                                                                        @elseif($isDisabled)
                                                                            — Unavailable
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                <option value="" disabled>No available instances</option>
                                                            @endif
                                                        </select>
                                                        @if($currentRowAssignedInstance && $currentRowAssignedInstance->equipmentInstance)
                                                            <div class="mt-2 text-xs text-blue-600">
                                                                <span class="font-semibold">Row {{ $i + 1 }}:</span> {{ $currentRowAssignedInstance->equipmentInstance->instance_code ?: ('Instance #' . $currentRowAssignedInstance->equipmentInstance->id) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <textarea name="pickup_notes[{{ $item->id }}][{{ $i }}]" 
                                                                  rows="2"
                                                                  class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                  placeholder="Any observations..."></textarea>
                                                    </td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-800">No equipment items found for this reservation.</p>
                    </div>
                @endif
            </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('reservation-management.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" id="submitBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="submitText">Mark as Picked Up</span>
                            <span id="submitSpinner" class="hidden">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            // Pickup condition column removed; no dynamic condition syncing required

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                
                // Show loading modal with better design
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="bg-blue-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Processing Pickup...</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="animate-spin w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700">Please wait while we process your equipment pickup request.</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'swal-custom-popup'
                    },
                    didOpen: () => {
                        const btn = document.querySelector('.swal2-popup .swal2-html-container + div button');
                        if (btn) { btn.blur(); }
                    }
                });

                // Submit the form after showing loading modal
                setTimeout(() => {
                    form.submit();
                }, 500);
            });

            // Check for success message and show modal
            @if(session('success'))
                // Show success modal with better design
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Equipment Picked Up Successfully!</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700">{{ session('success') }}</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105 border-0" style="border: none !important; outline: none !important; box-shadow: none !important;" onclick="Swal.close()">
                                OK
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                }).then(() => {
                    // Redirect to reservation management after modal closes
                    window.location.href = '{{ route('reservation-management.index') }}';
                });
            @endif
        });
    </script>

<style>
    /* Ensure SweetAlert2 OK button has no border/outline like approval modal */
    .swal2-actions button,
    .swal2-styled,
    .swal2-styled:focus,
    .swal2-confirm,
    .swal2-cancel,
    .swal2-popup button,
    .swal2-popup button:focus,
    .swal2-popup button:active,
    .swal2-popup button:hover,
    .swal2-popup button:focus-visible,
    .swal2-container button:focus,
    .swal2-container button:focus-visible {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        border-radius: 8px !important;
    }
    
    /* Target the specific OK button in success modal */
    .swal2-popup .swal2-html-container + div button,
    .swal2-popup .swal2-html-container + div button:focus,
    .swal2-popup .swal2-html-container + div button:active,
    .swal2-popup .swal2-html-container + div button:hover,
    .swal2-popup .swal2-html-container + div button:focus-visible {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        border-radius: 8px !important;
    }

    /* Tailwind ring reset for focused buttons (just in case) */
    .swal2-container button {
        --tw-ring-shadow: 0 0 #0000 !important;
        --tw-ring-offset-shadow: 0 0 #0000 !important;
    }
</style>
</x-app-layout>
