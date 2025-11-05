@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Activity Logs Test</h2>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Activity Logs</h3>
                    @if($activities->count() > 0)
                        <div class="space-y-4">
                            @foreach($activities as $activity)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $colorClass = match($activity->action_color) {
                                                        'green' => 'bg-green-100 text-green-600',
                                                        'blue' => 'bg-blue-100 text-blue-600',
                                                        'red' => 'bg-red-100 text-red-600',
                                                        'yellow' => 'bg-yellow-100 text-yellow-600',
                                                        'gray' => 'bg-gray-100 text-gray-600',
                                                        default => 'bg-gray-100 text-gray-600'
                                                    };
                                                @endphp
                                                <div class="w-8 h-8 {{ $colorClass }} rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity->action_icon }}"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $activity->action_description }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $activity->description }}
                                                </p>
                                                @if($activity->model_name)
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        Item: {{ $activity->model_name }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-500 mt-1">
                                                    User: {{ $activity->user->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 text-right">
                                            <p class="text-xs text-gray-500">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $activity->created_at->format('M d, Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No activity logs found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
