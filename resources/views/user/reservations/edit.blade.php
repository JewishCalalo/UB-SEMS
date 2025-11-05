<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Reservation') }} #{{ $reservation->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('reservations.update', $reservation) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Reservation Details -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Reservation Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    @if($reservation->createdBy && !$reservation->user)
                                        <p class="text-sm font-medium text-gray-500">PE Staff Member</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $reservation->name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-600">PE Class Equipment Reservation</p>
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-gray-500">Created by</p>
                                            <p class="text-sm text-gray-600">{{ $reservation->createdBy->name }} ({{ ucfirst($reservation->createdBy->role) }})</p>
                                        </div>
                                    @else
                                        <p class="text-sm font-medium text-gray-500">Requested By</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User') }}</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->user ? $reservation->user->email : ($reservation->email ?? 'No email') }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Request Date</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $reservation->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Equipment Items -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Equipment Items</h3>
                            <div class="space-y-4">
                                @foreach($reservation->items as $item)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $item->equipment->display_name }}</h4>
                                                <p class="text-sm text-gray-600">{{ $item->equipment->category->name }}</p>
                                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity_requested }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Available: {{ $item->equipment->quantity_available }}</p>
                                                <p class="text-sm text-gray-500">Total: {{ $item->equipment->quantity_total }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Status Update -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                    <select name="status" id="status" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        @php
                                            // Different status workflows for PE staff vs user reservations
                                            if ($reservation->createdBy && !$reservation->user) {
                                                // PE Staff reservation workflow - uses same statuses but different logic
                                                $allowedTransitions = [
                                                    'pending' => ['approved', 'denied'],
                                                    'approved' => ['picked_up', 'denied'],
                                                    'picked_up' => ['returned'],
                                                    'returned' => ['completed'],
                                                    'denied' => [],
                                                    'completed' => [],
                                                ];
                                            } else {
                                                // User reservation workflow
                                                $allowedTransitions = [
                                                    'pending' => ['approved', 'denied'],
                                                    'approved' => ['picked_up', 'denied'],
                                                    'picked_up' => ['returned'],
                                                    'returned' => ['completed'],
                                                    'denied' => [],
                                                    'completed' => [],
                                                ];
                                            }
                                            $currentStatus = $reservation->status;
                                            $allowedStatuses = $allowedTransitions[$currentStatus];
                                        @endphp
                                        
                                        @foreach(['pending', 'approved', 'denied', 'picked_up', 'returned', 'completed'] as $status)
                                            @if(in_array($status, $allowedStatuses) || $status === $currentStatus)
                                                <option value="{{ $status }}" {{ $reservation->status === $status ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if(empty($allowedStatuses))
                                        <p class="mt-1 text-sm text-gray-500">No further status changes allowed for {{ ucfirst(str_replace('_', ' ', $currentStatus)) }} reservations</p>
                                    @endif
                                </div>

                                @if(!$reservation->createdBy || $reservation->user)
                                    <!-- Pickup Date - Only for user reservations -->
                                    <div>
                                        <label for="pickup_date" class="block text-sm font-medium text-gray-700">Pickup Date</label>
                                        <input type="date" name="pickup_date" id="pickup_date" 
                                               value="{{ $reservation->pickup_date ? $reservation->pickup_date->format('Y-m-d') : '' }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-sm text-gray-500">Set pickup date when approving reservation</p>
                                    </div>
                                @else
                                    <!-- PE Staff reservation info -->
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">PE Class Equipment</p>
                                        <p class="mt-1 text-sm text-gray-600">Equipment is used during class time</p>
                                        <p class="text-sm text-gray-500">No pickup required - equipment stays in PE department</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Remarks</h3>
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">
                                    @if($reservation->createdBy && !$reservation->user)
                                        Class/Activity Notes
                                    @else
                                        Manager Remarks
                                    @endif
                                </label>
                                <textarea name="remarks" id="remarks" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="@if($reservation->createdBy && !$reservation->user)Add notes about the PE class or activity...@elseAdd any remarks or notes about this reservation...@endif">{{ $reservation->remarks }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">
                                    @if($reservation->createdBy && !$reservation->user)
                                        Optional notes about the PE class or activity
                                    @else
                                        Optional remarks for the user
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('reservations.show', $reservation) }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Update Reservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-show pickup date field when status is approved (only for user reservations)
        document.getElementById('status').addEventListener('change', function() {
            const pickupDateField = document.getElementById('pickup_date');
            if (pickupDateField) { // Only if pickup date field exists (user reservations)
                if (this.value === 'approved') {
                    pickupDateField.style.display = 'block';
                    pickupDateField.required = true;
                } else {
                    pickupDateField.style.display = 'block';
                    pickupDateField.required = false;
                }
            }
        });
    </script>
</x-app-layout>
