<div>
    <nav class="relative z-[300] {{ request()->routeIs('login') || request()->routeIs('welcome') || request()->routeIs('equipment.*') || request()->routeIs('reservations.track') || request()->routeIs('reservations.guest-confirmation') || request()->routeIs('reservations.confirmation') ? 'bg-white bg-opacity-95 backdrop-blur-sm shadow-lg border-b border-gray-200' : 'bg-white shadow-sm border-b border-gray-100' }}" x-data="{ mobileMenuOpen: false }">
        <div class="w-full h-1 bg-red-600"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Title -->
                <div class="flex items-center">
                    <h1 class="text-xl font-extrabold tracking-wide {{ request()->routeIs('login') ? 'text-gray-900' : 'text-gray-900' }}">SEMS</h1>
                    <span class="ml-2 text-sm {{ request()->routeIs('login') ? 'text-gray-700' : 'text-gray-600' }} hidden sm:inline">Sports Equipment Management</span>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Home / Landing Page -->
                    <a href="{{ route('welcome') }}" class="navigation__button {{ (request()->routeIs('welcome') || request()->is('/')) ? 'navigation__button--active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Home</span>
                    </a>

                    
                    <!-- Track Reservation Link -->
                    <a href="{{ route('reservations.track') }}" class="navigation__button {{ request()->routeIs('reservations.track') ? 'navigation__button--active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Track Reservation</span>
                    </a>
                    
                    <!-- Reservation Box (only on landing page) -->
                    @if (request()->routeIs('welcome'))
                        <div class="relative">
                            <button class="navigation__button--reservation-box" id="reservationButton">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l1.5 7m6.5-7l-1.5 7M9 21a2 2 0 110-4 2 2 0 010 4zm8 0a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                                <span>Reservation Box</span>
                                <span class="navigation__button--reservation-count" id="reservationCount">0</span>
                            </button>
                            
                            <!-- Reservation Dropdown -->
                            <div id="reservationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg border border-gray-200 z-[400]">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-3">Reservation Items</h3>
                                    <div id="reservationItems" class="space-y-3 max-h-64 overflow-y-auto">
                                        <!-- Reservation items will be populated here -->
                                    </div>
                                    <div class="border-t pt-3 mt-3">
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="font-medium">Total Items:</span>
                                            <span id="reservationTotalItems" class="font-semibold">0</span>
                                        </div>
                                        <button id="proceedToReservation" style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; padding: 8px 16px; border-radius: 6px; border: none; width: 100%; font-weight: 500; transition: all 0.2s; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                                                onmouseover="this.style.background='linear-gradient(to right, #b91c1c, #991b1b)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                onmouseout="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                            Proceed to Reservation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="navigation__button {{ request()->routeIs('dashboard') ? 'navigation__button--active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path d="M8 5V3a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="navigation__button">
                                <svg viewBox="0 0 24 24">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="navigation__button {{ request()->routeIs('login') ? 'navigation__button--active' : '' }}">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Staff Login</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                        <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" class="md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('welcome') }}" class="block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2 {{ request()->routeIs('welcome') ? 'text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Home</span>
                </a>

                
                <!-- Track Reservation -->
                <a href="{{ route('reservations.track') }}" class="block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2 {{ request()->routeIs('reservations.track') ? 'text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Track Reservation</span>
                </a>
                
                <!-- Reservation Box (only on landing page) -->
                @if (request()->routeIs('welcome'))
                    <button class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 flex items-center justify-between" id="mobileReservationButton">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l1.5 7m6.5-7l-1.5 7M9 21a2 2 0 110-4 2 2 0 010 4zm8 0a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                            <span>Reservation Box</span>
                        </div>
                        <span class="bg-red-600 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center" id="mobileReservationCount">0</span>
                    </button>
                @endif
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2 {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path d="M8 5V3a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 flex items-center space-x-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium flex items-center space-x-2 {{ request()->routeIs('login') ? 'text-gray-900' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Staff Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</div>
