<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SEMS') }} - Reservation #{{ $reservation->reservation_code }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <div class="bg-red-600 p-2 rounded mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">SEMS</h1>
                        <span class="ml-2 text-sm text-gray-600">Sports Equipment Management</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('equipment.index') }}" class="text-red-600 hover:text-red-800 px-3 py-2 rounded-md text-sm font-medium">
                        Equipment
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Staff Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                Reservation #{{ $reservation->reservation_code }}
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">
                                Submitted on {{ $reservation->created_at->format('M d, Y \a\t g:i A') }}
                            </p>
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
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
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

                    <!-- Borrower Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Borrower Information</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><strong>Name:</strong> {{ $reservation->user ? $reservation->user->name : $reservation->name }}</p>
                                <p><strong>Email:</strong> {{ $reservation->user ? $reservation->user->email : $reservation->email }}</p>
                                @if($reservation->user && $reservation->user->contact_number)
                                    <p><strong>Contact:</strong> {{ $reservation->user->contact_number }}</p>
                                @endif
                                @if($reservation->user && $reservation->user->department)
                                    <p><strong>Department:</strong> {{ $reservation->user->department }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Reservation Details</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><strong>Borrow Date:</strong> {{ $reservation->borrow_date->format('M d, Y') }}</p>
                                <p><strong>Return Date:</strong> {{ $reservation->return_date->format('M d, Y') }}</p>
                                <p><strong>Reason:</strong> {{ $reservation->reason }}</p>
                                @if($reservation->additional_details)
                                    <p><strong>Additional Details:</strong> {{ $reservation->additional_details }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Equipment Items -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-900 mb-3">Equipment Requested</h3>
                        <div class="space-y-3">
                            @foreach($reservation->items as $item)
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $item->equipment->primary_image ? Storage::url($item->equipment->primary_image->image_path) : asset('images/placeholder.jpg') }}" 
                                             alt="{{ $item->equipment->name }}" 
                                             class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->equipment->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->equipment->category->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->equipment->brand ?? 'N/A' }} {{ $item->equipment->model ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">Qty: {{ $item->quantity_requested }}</p>
                                        @if($item->quantity_approved && $item->quantity_approved != $item->quantity_requested)
                                            <p class="text-sm text-orange-600 font-medium">Approved: {{ $item->quantity_approved }}</p>
                                        @endif
                                        <p class="text-sm text-gray-600">
                                            @if($item->equipment->quantity_available >= $item->quantity_requested)
                                                <span class="text-green-600">Available</span>
                                            @else
                                                <span class="text-red-600">Limited</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-900 mb-3">Status Timeline</h3>
                        <div class="space-y-4">
                            <!-- Reservation Submitted - Always shown -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mt-2"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Reservation Submitted</p>
                                    <p class="text-sm text-gray-600">{{ $reservation->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>

                            <!-- Approval/Denial - Show if approved_at exists -->
                            @if($reservation->approved_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 
                                            @if($reservation->status === 'approved') bg-green-400
                                            @elseif($reservation->status === 'denied') bg-red-400
                                            @else bg-gray-400 @endif rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            Reservation {{ ucfirst($reservation->status) }}
                                            @if($reservation->approvedBy)
                                                by {{ $reservation->approvedBy->name }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $reservation->approved_at->format('M d, Y \a\t g:i A') }}</p>
                                        @if($reservation->remarks)
                                            <p class="text-sm text-gray-600 mt-1">{{ $reservation->remarks }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Pickup Date Set - Show if pickup_date exists and reservation is approved or picked up -->
                            @if($reservation->pickup_date && in_array($reservation->status, ['approved', 'picked_up', 'returned', 'completed']))
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Pickup Date Set</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->pickup_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Equipment Picked Up - Show if picked_up_at exists -->
                            @if($reservation->picked_up_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Equipment Picked Up</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->picked_up_at->format('M d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Equipment Returned - Show if returned_at exists -->
                            @if($reservation->returned_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-purple-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Equipment Returned</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->returned_at->format('M d, Y \a\t g:i A') }}</p>
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
                                                {{ $reservation->cancelled_at->format('M d, Y \a\t g:i A') }}
                                            @else
                                                Cancelled
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Next Steps -->
                    @if($reservation->status === 'pending')
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <h4 class="font-medium text-blue-900 mb-2">What's Next?</h4>
                            <p class="text-sm text-blue-800">
                                Your reservation is currently under review. Staff will review your request and notify you of the decision via email. 
                                You can check back here anytime using your reservation code to see the latest status.
                            </p>
                        </div>
                    @elseif($reservation->status === 'approved')
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md">
                            <h4 class="font-medium text-green-900 mb-2">Reservation Approved!</h4>
                            <p class="text-sm text-green-800">
                                Congratulations! Your reservation has been approved. Please pick up your equipment on the scheduled date. 
                                Remember to return all items by the return date to avoid any penalties.
                            </p>
                        </div>
                    @elseif($reservation->status === 'denied')
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-md">
                            <h4 class="font-medium text-red-900 mb-2">Reservation Denied</h4>
                            <p class="text-sm text-red-800">
                                Unfortunately, your reservation request has been denied. If you have any questions, 
                                please contact the Physical Education Office directly.
                            </p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-6 border-t">
                        <div class="flex space-x-3">
                            <a href="{{ route('equipment.index') }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-150">
                                Browse Equipment
                            </a>
                        </div>
                        
                        @auth
                            @if(Auth::user()->hasAnyRole(['manager', 'admin']) || Auth::id() === $reservation->user_id)
                                <div class="flex space-x-3">
                                    @if(Auth::user()->hasAnyRole(['manager', 'admin']))
                                        <a href="{{ route('reservations.edit', $reservation) }}" 
                                           class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-150">
                                            Edit Reservation
                                        </a>
                                    @endif
                                    
                                    @if(Auth::id() === $reservation->user_id && $reservation->status === 'pending')
                                        <button type="button" 
                                                onclick="showCancelReservationConfirmation('{{ $reservation->id }}', '{{ $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User') }}')"
                                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-150">
                                            Cancel Reservation
                                        </button>
                                        
                                        <!-- Hidden form for cancellation -->
                                        <form id="cancel-reservation-show-form" 
                                              method="POST" 
                                              action="{{ route('reservations.destroy', $reservation) }}" 
                                              class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        

                                    @endif
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Cancel Reservation Confirmation Modal
        function showCancelReservationConfirmation(reservationId, userName) {
            Swal.fire({
                title: 'Cancel Reservation?',
                html: `Are you sure you want to cancel reservation #${reservationId} for <strong>${userName}</strong>? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Cancel Reservation',
                cancelButtonText: 'Keep Reservation',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-reservation-show-form').submit();
                }
            });
        }
    </script>
</body>
</html>
