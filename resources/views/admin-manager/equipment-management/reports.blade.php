<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Equipment Reports') }}
            </h2>
            <a href="{{ route('equipment-management.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Back to Equipment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Available Equipment</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $equipmentByAvailability['available'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Needs Maintenance</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $equipmentByAvailability['needs_maintenance'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Equipment by Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipment by Category</h3>
                        @if($equipmentByCategory->count() > 0)
                            <div class="space-y-3">
                                @foreach($equipmentByCategory as $category)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $category->category->name }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $category->count }} items</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No equipment categories found</p>
                        @endif
                    </div>
                </div>

                <!-- Equipment by Condition -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipment by Condition</h3>
                        @if($equipmentByCondition->count() > 0)
                            <div class="space-y-3">
                                @foreach($equipmentByCondition as $condition)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 {{ $condition->condition === 'excellent' ? 'bg-green-500' : ($condition->condition === 'good' ? 'bg-blue-500' : ($condition->condition === 'fair' ? 'bg-yellow-500' : 'bg-red-500')) }} rounded-full mr-3"></div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ ucfirst($condition->condition) }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $condition->count }} items</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No equipment condition data found</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Most Borrowed Equipment -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Borrowed Equipment</h3>
                    @if($mostBorrowed->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Borrowed</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($mostBorrowed as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->brand }} {{ $item->model }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $item->category_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">{{ $item->total_borrowed }} times</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No borrowing data found</p>
                    @endif
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>
