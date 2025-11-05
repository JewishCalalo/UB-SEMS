<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipment Returns') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Reservation Management', 'url' => route('reservation-management.index')],
                ['label' => 'Equipment Returns']
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
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Process Equipment Return</h3>
                        <p class="text-gray-600">Record the condition of equipment being returned for this reservation</p>
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

                    <!-- Equipment Return Form -->
                    <form id="returnForm" method="POST" action="{{ route('equipment-returns.process', $reservation) }}" class="space-y-6" novalidate>
                        @csrf
                        
                        <div class="mb-8">
                            <!-- Equipment Return Table Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">Equipment Return Details</h3>
                                <p class="text-sm text-gray-600 mt-1">Review and update the condition of each equipment instance being returned</p>
                            </div>
                            
                            @if($reservation->items->count() > 0)
                                <!-- Equipment Return Table -->
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="p-6">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                            <i class="fas fa-table mr-2 text-gray-600"></i>
                                            Equipment Instances to Return
                                        </h4>
                                        <!-- Inline Error Notification -->
                                        @if($errors->any())
                                            @php
                                                $messages = [];
                                                foreach($errors->getMessages() as $key => $errs){
                                                    if(\Illuminate\Support\Str::contains($key, 'returned_condition')){
                                                        $messages['returned_condition'] = 'Please choose a returned condition for each item.';
                                                    } elseif(\Illuminate\Support\Str::contains($key, 'condition_notes')){
                                                        $messages['condition_notes'] = 'Please add brief notes for items that need context (optional for others).';
                                                    } elseif(\Illuminate\Support\Str::contains($key, 'damage_description')){
                                                        // Damage description column removed; ignore related messages if any linger
                                                        continue;
                                                    } else {
                                                        $messages[$key] = $errs[0];
                                                    }
                                                }
                                            @endphp
                                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                                <div class="flex items-start">
                                                    <svg class="h-5 w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-bold text-red-800">Please review the form:</h3>
                                                        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1 font-semibold">
                                                            @foreach($messages as $m)
                                                                <li>{{ $m }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                            
                                <!-- Individual Equipment Tables - Only show approved items -->
                                <div class="space-y-8">
                                    @foreach($reservation->items->where('quantity_approved', '>', 0) as $item)
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
                                                            <h4 class="text-lg font-semibold text-gray-900">{{ $item->equipment->name }}</h4>
                                                            <div class="flex items-center space-x-2 mt-1">
                                                                <span class="text-sm font-medium text-gray-700">{{ $item->equipment->brand ?: 'No brand' }}</span>
                                                                <span class="text-sm text-gray-500">•</span>
                                                                <span class="text-sm text-gray-500">{{ $item->equipment->model ?: 'No model' }}</span>
                                                            </div>
                                                            <div class="flex items-center space-x-2 mt-1">
                                                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $item->equipment->category->name }}</span>
                                                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">{{ $item->equipment->equipmentType->name ?? 'N/A' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-sm font-medium text-gray-900">Quantity: {{ $item->instances->count() }}</div>
                                                        <div class="text-xs text-gray-500">Instances to return</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Equipment Instances Table -->
                                            <div class="p-6">
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-blue-600">
                                                            <tr>
                                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Instance Code</th>
                                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Pickup Condition</th>
                                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Returned Condition</th>
                                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Notes</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            @foreach($item->instances as $index => $instance)
                                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ $instance->equipmentInstance->instance_code ?: 'Instance #' . $instance->equipmentInstance->id }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $instance->equipmentInstance->location ?? 'No location specified' }}
                                                                    </div>
                                                                    <div class="text-xs text-gray-400">
                                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                            Picked_up
                                                                </span>
                                                                @php
                                                                    $ir = $incidentInstanceSeverities[$instance->equipmentInstance->id] ?? null;
                                                                @endphp
                                                                @if($ir)
                                                                    <span class="inline-flex items-center ml-2 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800" title="From Incident {{ $ir['incident_code'] }}">
                                                                        Reported: {{ str_replace('_',' ', $ir['severity']) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                                    @php
                                                                        $pickupRecord = $item->reservationItemInstances->where('equipment_instance_id', $instance->equipmentInstance->id)->first();
                                                                        $pickupCondition = $pickupRecord ? $pickupRecord->pickup_condition : null;
                                                                        $pickupNotes = $pickupRecord ? $pickupRecord->pickup_notes : null;
                                                                    @endphp
                                                                    
                                                                    @if($pickupCondition)
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                            {{ $pickupCondition === 'excellent' ? 'bg-green-100 text-green-800' : 
                                                                               ($pickupCondition === 'good' ? 'bg-blue-100 text-blue-800' : 
                                                                               ($pickupCondition === 'fair' ? 'bg-yellow-100 text-yellow-800' : 
                                                                               ($pickupCondition === 'needs_repair' ? 'bg-orange-100 text-orange-800' : 
                                                                               ($pickupCondition === 'damaged' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))) }}">
                                                                            {{ ucfirst($pickupCondition) }}
                                                            </span>
                                                                        @if($pickupNotes)
                                                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($pickupNotes, 50) }}</div>
                                                                @endif
                                                            @else
                                                                <span class="text-xs text-gray-400 italic">Not recorded</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                                    <select name="returns[{{ $instance->equipmentInstance->id }}][returned_condition]" 
                                                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                            data-pickup-condition="{{ $pickupCondition ?? '' }}"
                                                                            data-instance-id="{{ $instance->equipmentInstance->id }}"
                                                                            required>
                                                                @php
                                                                    $defaultReturn = $ir['severity'] ?? '';
                                                                @endphp
                                                                <option value="">Select condition...</option>
                                                                <option value="excellent" {{ $defaultReturn==='excellent' ? 'selected' : '' }}>Excellent</option>
                                                                <option value="good" {{ $defaultReturn==='good' ? 'selected' : '' }}>Good</option>
                                                                <option value="fair" {{ $defaultReturn==='fair' ? 'selected' : '' }}>Fair</option>
                                                                <option value="needs_repair" {{ $defaultReturn==='needs_repair' ? 'selected' : '' }}>Needs Repair</option>
                                                                <option value="damaged" {{ $defaultReturn==='damaged' ? 'selected' : '' }}>Damaged</option>
                                                                <option value="lost" {{ $defaultReturn==='lost' ? 'selected' : '' }}>Lost</option>
                                                            </select>
                                                            <div class="text-xs mt-1 text-amber-600 hidden" id="return-notice-{{ $instance->equipmentInstance->id }}">
                                                                Note: The selected return condition is higher than the recorded pickup condition.
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                                    <textarea name="returns[{{ $instance->equipmentInstance->id }}][condition_notes]" 
                                                                              rows="2"
                                                                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                              placeholder="Describe the current condition..."></textarea>
                                                        </td>
                                                        
                                                    </tr>
                                                            <!-- Hidden field for equipment instance ID -->
                                                            <input type="hidden" name="returns[{{ $instance->equipmentInstance->id }}][equipment_instance_id]" value="{{ $instance->equipmentInstance->id }}">
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800">No equipment instances found for this reservation.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('reservation-management.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" id="submitBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submitText">Process Return</span>
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

                    <script>
                        document.addEventListener('DOMContentLoaded', function(){
                            const rank = { excellent: 5, good: 4, fair: 3, needs_repair: 2, damaged: 1, lost: 0 };
                            document.querySelectorAll('select[name^="returns["]').forEach(function(sel){
                                const pickup = sel.getAttribute('data-pickup-condition') || '';
                                const instanceId = sel.getAttribute('data-instance-id');
                                const notice = document.getElementById('return-notice-' + instanceId);
                                function updateNotice(){
                                    const ret = sel.value;
                                    if (pickup && rank[ret] !== undefined && rank[pickup] !== undefined && rank[ret] > rank[pickup]){
                                        notice && notice.classList.remove('hidden');
                                    } else {
                                        notice && notice.classList.add('hidden');
                                    }
                                }
                                sel.addEventListener('change', updateNotice);
                                updateNotice();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('returnForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                
                // Show loading modal
                Swal.fire({
                    title: 'Submitting request...',
                    text: 'Please wait while we process your return request.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the form after a brief delay to ensure the modal is visible
                const MIN_LOADING_MS = 1000;
                const start = Date.now();
                const submitNow = () => form.submit();
                const elapsed = Date.now() - start;
                const remaining = Math.max(0, MIN_LOADING_MS - elapsed);
                setTimeout(submitNow, remaining);
            });

            // Check for success message and show modal
            @if(session('success'))
                // Show success modal with better design
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Equipment Returned Successfully!</h2>
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
                    },
                    didOpen: () => {
                        const btn = document.querySelector('.swal2-popup .swal2-html-container + div button');
                        if (btn) { btn.blur(); }
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
