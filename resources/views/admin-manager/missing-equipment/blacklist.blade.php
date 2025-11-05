<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-3">
            {{ __('Blacklisted Emails') }}
            <span class="inline-flex items-center text-sm font-bold rounded-full px-3 py-1.5 bg-gradient-to-r from-red-600 to-red-700 text-white shadow-sm">{{ number_format($items->total()) }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @push('head')
                @vite('resources/js/components/sweetalert2-utils.js')
            @endpush
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Lost & Damaged'],
                ['label' => 'Blacklisted Emails']
            ]" />

            <!-- Themed intro section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-6">
                    <h3 class="text-2xl font-bold mb-2">Blacklist Management</h3>
                    <p class="text-red-100 text-sm font-medium">Control access to reservation system</p>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 text-base leading-relaxed font-medium">
                        Manage emails prevented from making reservations due to unresolved lost or damaged items. 
                        You can search, filter, and release emails when appropriate.
                    </p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-lg mb-8 p-6">
                <div class="flex justify-between items-center">
                    <h4 class="text-xl font-bold text-gray-900">Search & Filter</h4>
                    <button type="button" onclick="toggleSearchFilter()"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <span id="toggleText">Show</span>
                        <svg id="toggleIcon" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-xl shadow-lg mb-8" style="display: none;">
                <div class="p-8">
                    <form method="GET" action="{{ route('blacklist.index') }}" id="blacklistSearchForm" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="block text-base font-bold text-gray-800">Search Email</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter email address to search..." 
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base font-medium transition-all duration-200">
                            </div>
                            <div class="space-y-3 flex items-end">
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-base font-bold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-lg font-semibold text-gray-900">Action Legend</h4>
                    <button type="button" onclick="ManagementCommon.toggleActionLegend()"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md hover:scale-105 transition-all duration-200"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <span id="actionLegendToggleText">Hide</span>
                        <svg id="actionLegendToggleIcon" class="w-4 h-4 transition-transform duration-200 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                <div id="actionLegendContent" class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm bg-gradient-to-r from-emerald-500 to-green-600">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">Release</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Blacklisted Emails</h3>
                        <x-table-pagination :paginator="$items" />
                    </div>
                    
                    @if($items->count() > 0)
                        <x-table-toolbar />
                    @endif

                    <div id="blacklistTableWrapper" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-600">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Email Address</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Reason</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($items as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->email }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $item->reason ?: '—' }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <form method="POST" action="{{ route('blacklist.release') }}" onsubmit="return handleRelease(event, this)" class="inline">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ $item->email }}">
                                                <button type="submit" title="Release from blacklist" aria-label="Release from blacklist"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg shadow-sm bg-gradient-to-r from-emerald-500 to-green-600 text-white hover:shadow-md hover:scale-105 transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-3 sm:px-6 py-8 text-center">
                                            <div class="text-gray-500 text-sm font-medium">No blacklisted emails found.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $items->links() }}</div>
                    <script>
                        function toggleSearchFilter(){
                            const c=document.getElementById('searchFilterContent');
                            const t=document.getElementById('toggleText');
                            const i=document.getElementById('toggleIcon');
                            if(!c||!t||!i) return;
                            const show = c.style.display==='none'||c.style.display==='';
                            c.style.display = show ? 'block' : 'none';
                            t.textContent = show ? 'Hide' : 'Show';
                            i.style.transform = show ? 'rotate(180deg)' : 'rotate(0deg)';
                        }

                        function handleRelease(e, form){
                            e.preventDefault();
                            Swal.fire({
                                title: '',
                                html: `
                                    <div class="bg-gradient-to-r from-emerald-600 to-green-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                        <h2 class="text-xl font-bold">Release email from blacklist?</h2>
                                    </div>
                                    <div class="space-y-4 text-left">
                                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                            <div class="flex items-start gap-3">
                                                <div class="p-1 bg-amber-100 rounded">
                                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-amber-800 mb-1">Confirmation Required</h4>
                                                    <p class="text-amber-700 text-sm">Type "CONFIRM" in the field below to proceed with releasing this email.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Type "CONFIRM" to proceed:</label>
                                            <input type="text" id="releaseConfirmInput" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-sm font-medium transition-all" placeholder="Type CONFIRM here...">
                                        </div>
                                        <div class="flex justify-between mt-6">
                                            <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">Cancel</button>
                                            <button type="button" id="releaseConfirmBtn" class="px-6 py-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-lg hover:from-emerald-700 hover:to-green-700 transition-all transform hover:scale-105">Release</button>
                                        </div>
                                    </div>
                                `,
                                showConfirmButton: false,
                                showCancelButton: false,
                                width: '600px',
                                customClass: { popup: 'swal-custom-popup' },
                                didOpen: () => {
                                    const input = document.getElementById('releaseConfirmInput');
                                    const btn = document.getElementById('releaseConfirmBtn');
                                    if (input) input.focus();
                                    if (btn) {
                                        btn.addEventListener('click', function(){
                                            const val = (input?.value || '').trim().toUpperCase();
                                            if (val !== 'CONFIRM') {
                                                Swal.showValidationMessage('Please type "CONFIRM" to continue');
                                                return;
                                            }
                                            form.submit();
                                        });
                                    }
                                }
                            });
                            return false;
                        }

                        @if(session('success'))
                        SweetAlertUtils.success('Success','{{ session('success') }}');
                        @endif
                    </script>

                    <script>
                        // AJAX search functionality
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('blacklistSearchForm');
                            if (form) {
                                form.addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    
                                    const url = new URL(form.action, window.location.origin);
                                    const data = new FormData(form);
                                    
                                    // Clean params first
                                    url.search = '';
                                    for (const [k, v] of data.entries()) { 
                                        if (v) url.searchParams.set(k, v); 
                                    }
                                    
                                    // Fetch and replace table content
                                    fetch(url)
                                        .then(response => response.text())
                                        .then(html => {
                                            const parser = new DOMParser();
                                            const doc = parser.parseFromString(html, 'text/html');
                                            const newTable = doc.querySelector('#blacklistTableWrapper');
                                            const currentTable = document.querySelector('#blacklistTableWrapper');
                                            
                                            if (newTable && currentTable) {
                                                currentTable.innerHTML = newTable.innerHTML;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            // Fallback to regular form submission
                                            form.submit();
                                        });
                                });
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


