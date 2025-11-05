<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipment Return History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Return History</h3>
                <div class="text-sm text-gray-500">
                    Track all equipment returns and condition changes
                </div>
            </div>

            <!-- Return Logs Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($returnLogs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('equipment-returns.history', array_merge(request()->query(), ['sort' => 'returned_at', 'direction' => request('direction') === 'asc' && request('sort')==='returned_at' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1">
                                                Return Date
                                                <span class="ml-1 inline-flex flex-col leading-none">
                                                    <i class="fas fa-caret-up {{ request('sort')==='returned_at' && request('direction')==='asc' ? 'text-gray-700' : 'text-gray-300' }}"></i>
                                                    <i class="fas fa-caret-down {{ request('sort')==='returned_at' && request('direction')==='desc' ? 'text-gray-700' : 'text-gray-300' }}"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reservation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instance</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantities</th>
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
                                                <div class="text-sm text-gray-500">
                                                    {{ $log->reservation->user->name ?? 'Guest User' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $log->equipmentInstance->equipment->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $log->equipmentInstance->equipment->brand ?? 'No brand' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $log->equipmentInstance->instance_code }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $log->equipmentInstance->location ?? 'No location' }}
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
                                                @if($log->condition_notes)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ Str::limit($log->condition_notes, 50) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <span class="font-medium">{{ $log->quantity_returned }}</span> returned
                                                </div>
                                                @if($log->quantity_damaged > 0 || $log->quantity_lost > 0)
                                                    <div class="text-xs text-red-600 mt-1">
                                                        @if($log->quantity_damaged > 0)
                                                            {{ $log->quantity_damaged }} damaged
                                                        @endif
                                                        @if($log->quantity_damaged > 0 && $log->quantity_lost > 0)
                                                            , 
                                                        @endif
                                                        @if($log->quantity_lost > 0)
                                                            {{ $log->quantity_lost }} lost
                                                        @endif
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No return records found</h3>
                            <p class="mt-1 text-sm text-gray-500">Equipment returns will appear here once processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
