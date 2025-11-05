<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instance History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Instance Details Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $instance->equipment->name }} - {{ $instance->instance_code }}
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-500">Brand:</span>
                                    <span class="text-gray-900">{{ $instance->equipment->brand ?? 'No brand' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500">Current Condition:</span>
                                    <span class="text-gray-900">{{ ucfirst($instance->condition) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500">Location:</span>
                                    <span class="text-gray-900">{{ $instance->location ?? 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500">Status:</span>
                                    @if($instance->is_available)
                                        <span class="text-green-600 font-medium">Available</span>
                                    @else
                                        <span class="text-red-600 font-medium">Unavailable</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('equipment-returns.history') }}" 
                               class="text-red-600 hover:text-red-900 text-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Returns
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return History Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Return History</h4>
                    
                    @if($returnLogs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('equipment-returns.instance-history', array_merge(['instance' => $instance->id], request()->query(), ['sort' => 'returned_at', 'direction' => request('direction') === 'asc' && request('sort')==='returned_at' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1">
                                                Return Date
                                                <span class="ml-1 inline-flex flex-col leading-none">
                                                    <i class="fas fa-caret-up {{ request('sort')==='returned_at' && request('direction')==='asc' ? 'text-gray-700' : 'text-gray-300' }}"></i>
                                                    <i class="fas fa-caret-down {{ request('sort')==='returned_at' && request('direction')==='desc' ? 'text-gray-700' : 'text-gray-300' }}"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reservation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penalties</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Processed By</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($returnLogs as $log)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $log->returned_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $log->returned_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $log->reservation->reservation_code }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $log->reservation->borrow_date->format('M d, Y') }} - {{ $log->reservation->return_date->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $log->reservation->user->name ?? 'Guest User' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $log->reservation->user->email ?? 'No email' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $conditionColors = [
                                                        'excellent' => 'bg-green-100 text-green-800',
                                                        'good' => 'bg-blue-100 text-blue-800',
                                                        'fair' => 'bg-yellow-100 text-yellow-800',
                                                        'needs_repair' => 'bg-orange-100 text-orange-800',
                                                        'damaged' => 'bg-red-100 text-red-800',
                                                        'lost' => 'bg-gray-100 text-gray-800'
                                                    ];
                                                @endphp
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $conditionColors[$log->returned_condition] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($log->returned_condition) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <div><strong>Returned:</strong> {{ $log->quantity_returned }}</div>
                                                    @if($log->quantity_damaged > 0)
                                                        <div class="text-red-600"><strong>Damaged:</strong> {{ $log->quantity_damaged }}</div>
                                                    @endif
                                                    @if($log->quantity_lost > 0)
                                                        <div class="text-red-600"><strong>Lost:</strong> {{ $log->quantity_lost }}</div>
                                                    @endif
                                                </div>
                                                @if($log->condition_notes)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ Str::limit($log->condition_notes, 60) }}
                                                    </div>
                                                @endif
                                                @if($log->damage_description)
                                                    <div class="text-xs text-red-600 mt-1">
                                                        <strong>Damage:</strong> {{ Str::limit($log->damage_description, 60) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($log->quantity_damaged > 0 || $log->quantity_lost > 0)
                                                    <div class="text-sm font-medium text-red-600">
                                                        ${{ number_format($log->total_penalty, 2) }}
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-500">No penalties</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $log->processedBy->name }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $returnLogs->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No return history for this instance</h3>
                            <p class="mt-1 text-sm text-gray-500">This equipment instance hasn't been returned yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
