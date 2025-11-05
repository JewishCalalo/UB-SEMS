<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Reports']
            ]" />
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Instructor Reports</h3>
                        <p class="text-gray-600 font-medium">Generate and export your activity reports</p>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-chart-line mr-2 text-red-500"></i>
                        Analytics & Reports
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mb-4 flex justify-end">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-8 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back
                </a>
            </div>

            <!-- Report Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                    <h4 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Report Filters
                    </h4>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('instructor.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="reservations" {{ $reportType === 'reservations' ? 'selected' : '' }}>Reservations</option>
                                <option value="incidents" {{ $reportType === 'incidents' ? 'selected' : '' }}>Incidents</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Export Options -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                    <h4 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Options
                    </h4>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('instructor.reports.export') }}" class="flex space-x-4">
                        @csrf
                        <input type="hidden" name="type" value="{{ $reportType }}">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        
                        <button type="submit" name="format" value="pdf" 
                                class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export PDF
                        </button>
                        
                        <button type="submit" name="format" value="excel" 
                                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </button>
                    </form>
                </div>
            </div>

            <!-- Report Content -->
            @if($reportType === 'reservations')
                @include('instructor.reports.partials.reservations', ['data' => $data])
            @elseif($reportType === 'incidents')
                @include('instructor.reports.partials.incidents', ['data' => $data])
            @endif
        </div>
    </div>
</x-app-layout>
