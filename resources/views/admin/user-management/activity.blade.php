<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('profile-user-management.show', $user) }}" class="text-red-600 hover:text-red-800">
                    ← Back to User Details
                </a>
            </div>

            <!-- User Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('reservations')" 
                                class="tab-button border-b-2 border-red-500 py-4 px-1 text-sm font-medium text-red-600"
                                id="reservations-tab">
                            Reservations ({{ $reservations->count() }})
                        </button>

                    </nav>
                </div>

                <div class="p-6">
                    <!-- Reservations Tab -->
                    <div id="reservations-content" class="tab-content">
                        @if($reservations->count() > 0)
                            <div class="space-y-4">
                                @foreach($reservations as $reservation)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <span class="px-2 py-1 text-xs rounded-full 
                                                        @if($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($reservation->status === 'approved') bg-green-100 text-green-800
                                                        @elseif($reservation->status === 'denied') bg-red-100 text-red-800
                                                        @elseif($reservation->status === 'picked_up') bg-blue-100 text-blue-800
                                                        @elseif($reservation->status === 'returned') bg-gray-100 text-gray-800
                                                        @elseif($reservation->status === 'overdue') bg-orange-100 text-orange-800
                                                        @elseif($reservation->status === 'cancelled') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ ucfirst($reservation->status) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">{{ $reservation->created_at->format('M d, Y H:i') }}</span>
                                                    <span class="text-xs text-gray-500">Code: {{ $reservation->reservation_code }}</span>
                                                </div>
                                                
                                                <div class="space-y-2">
                                                    @foreach($reservation->items as $item)
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-gray-600">•</span>
                                                            <span class="text-sm font-medium text-gray-900">{{ $item->equipment->name }}</span>
                                                            <span class="text-sm text-gray-500">(Qty: {{ $item->quantity }})</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                @if($reservation->reason)
                                                    <div class="mt-2">
                                                        <span class="text-sm font-medium text-gray-700">Reason:</span>
                                                        <span class="text-sm text-gray-600">{{ $reservation->reason }}</span>
                                                    </div>
                                                @endif
                                                
                                                <div class="mt-2 text-sm text-gray-500">
                                                    <span>Borrow: {{ $reservation->borrow_date->format('M d, Y') }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>Return: {{ $reservation->return_date->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination for Reservations -->
                            <div class="mt-6">
                                {{ $reservations->links() }}
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations found</h3>
                                <p class="mt-1 text-sm text-gray-500">This user hasn't made any reservations yet.</p>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('border-red-500', 'text-red-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            const selectedContent = document.getElementById(tabName + '-content');
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }
            
            // Add active state to selected tab button
            const selectedButton = document.getElementById(tabName + '-tab');
            if (selectedButton) {
                selectedButton.classList.remove('border-transparent', 'text-gray-500');
                selectedButton.classList.add('border-red-500', 'text-red-600');
            }
        }
    </script>
</x-app-layout>
