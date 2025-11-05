@props(['title' => null])
<div class="bg-red-600 text-white shadow-lg border-b border-red-500">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-8 flex items-center justify-between">
		<h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $title ?? '' }}</h1>
		<div class="text-sm text-red-100 font-medium">{{ now()->format('M d, Y') }}</div>
	</div>
</div>
