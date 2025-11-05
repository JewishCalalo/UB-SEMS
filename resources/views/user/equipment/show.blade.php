<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SEMS') }} - {{ $equipment->display_name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite([
        'resources/css/app.css', 
        'resources/css/components/buttons.css',
        'resources/css/modules/auth.css',
        'resources/css/modules/welcome.css',
        'resources/js/app.js'
    ])
</head>
<body class="font-sans antialiased public-page">
    <!-- Navigation -->
    <x-welcome-navigation/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Images -->
                        <div>
                            <div class="mb-4">
                                @if($equipment->images->count() > 0)
                                    <img src="{{ $equipment->images->first()->url }}" 
                                         alt="{{ $equipment->display_name }}" class="w-full h-96 object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" 
                                         alt="{{ $equipment->display_name }}" class="w-full h-96 object-cover rounded-lg">
                                @endif
                            </div>
                            
                            @if($equipment->images->count() > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($equipment->images->skip(1) as $image)
                                        <img src="{{ $image->url }}" 
                                             alt="{{ $equipment->display_name }}" class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity"
                                             onclick="changeMainImage('{{ $image->url }}')">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div>
                            <h1 class="text-3xl font-bold mb-4">{{ $equipment->display_name }}</h1>
                            
                            <div class="space-y-3">
                                <p><strong>Category:</strong> {{ $equipment->category->name }}</p>
                                @if($equipment->equipmentType)
                                    <p><strong>Equipment Type:</strong> {{ $equipment->equipmentType->name }}</p>
                                @endif
                                <p><strong>Brand:</strong> {{ $equipment->brand ?? 'N/A' }}</p>
                                <p><strong>Model:</strong> {{ $equipment->model ?? 'N/A' }}</p>
                                <p><strong>Location:</strong> {{ $equipment->location ?? 'N/A' }}</p>
                                
                                <div class="flex items-center">
                                    <strong>Condition:</strong>
                                    <span class="ml-2 px-2 py-1 rounded text-sm 
                                        @if($equipment->condition == 'excellent') bg-green-100 text-green-800
                                        @elseif($equipment->condition == 'good') bg-blue-100 text-blue-800
                                        @elseif($equipment->condition == 'fair') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($equipment->condition) }}
                                    </span>
                                </div>

                                <div class="flex items-center">
                                    <strong>Availability:</strong>
                                    <span class="ml-2 px-2 py-1 rounded text-sm 
                                        @if($equipment->quantity_available > 0) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $equipment->quantity_available }} / {{ $equipment->quantity_total }} available
                                    </span>
                                </div>

                                
                                <p><strong>Purchase Date:</strong> {{ $equipment->purchase_date ? $equipment->purchase_date->format('M d, Y') : 'N/A' }}</p>
                                
                                <div class="mt-4">
                                    <h3 class="font-semibold mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $equipment->description ?? 'No description available.' }}</p>
                                </div>

                                                                 <div class="mt-6 flex space-x-4">
                                     @if($equipment->quantity_available > 0)
                                         <div class="flex items-center space-x-2">
                                             <input type="number" 
                                                    min="1" 
                                                    max="{{ $equipment->quantity_available }}" 
                                                    value="1" 
                                                    class="w-20 px-3 py-2 border rounded quantity-input"
                                                    id="equipment-quantity">
                                             <button onclick="addToCart({{ $equipment->id }}, '{{ $equipment->display_name }}', {{ $equipment->quantity_available }})" 
                                                     class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium">
                                                 Add to Cart
                                             </button>
                                         </div>
                                         

                                     @else
                                         <button onclick="addToWishlist({{ $equipment->id }}, '{{ $equipment->display_name }}')" 
                                                 class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium">
                                             <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                             </svg>
                                             Add to Wishlist
                                         </button>
                                     @endif
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Form Modal -->
    <div id="reservationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto p-6 border w-full max-w-2xl shadow-2xl rounded-xl bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Complete Your Reservation</h3>
                
                <!-- Approval Process Information removed per requirement -->
                
                <form id="reservationForm" method="POST" action="{{ route('reservations.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="cart_data" id="cartDataInput">
                    
                    <!-- Personal Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                                         <input type="text" name="name" id="name" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                                         <input type="email" name="email" id="email" required 
                                                                         placeholder="12345678@s.ubaguio.edu or 12345678@e.ubaguio.edu"
                                     class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                               <p class="mt-1 text-sm text-gray-500">Use your University of Baguio email (e.g., 12345678@s.ubaguio.edu, 87654321@e.ubaguio.edu)</p>
                        </div>
                        
                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number *</label>
                            <input type="tel" name="contact_number" id="contact_number" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                        
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">Department/Course</label>
                            <input type="text" name="department" id="department" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>
                    
                    <!-- Reservation Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="borrow_date" class="block text-sm font-medium text-gray-700">Borrow Date *</label>
                                                         <input type="date" name="borrow_date" id="borrow_date" required 
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        </div>
                        
                        <div>
                            <label for="return_date" class="block text-sm font-medium text-gray-700">Return Date *</label>
                                                         <input type="date" name="return_date" id="return_date" required 
                                    min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Reservation *</label>
                                                 <textarea name="reason" id="reason" rows="3" required 
                                   placeholder="Please describe why you need this equipment..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
                    </div>
                    
                    <div>
                        <label for="additional_details" class="block text-sm font-medium text-gray-700">Additional Details</label>
                                                 <textarea name="additional_details" id="additional_details" rows="2" 
                                   placeholder="Any additional information..."
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
                    </div>
                    
                    <!-- Cart Summary -->
                    <div class="border-t pt-4">
                        <h4 class="font-medium text-gray-900 mb-2">Reservation Summary</h4>
                        <div id="modalCartItems" class="space-y-2 text-sm text-gray-600">
                            <!-- Cart items will be displayed here -->
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeReservationModal()" 
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                                                 <button type="submit" 
                                 class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                             Submit Reservation
                         </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <script>
        // Back button functionality
        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.origin)) {
                // If there's a previous page from the same site, go back
                window.history.back();
            } else {
                // If no previous page or from external site, go to welcome page
                window.location.href = '{{ route("welcome") }}';
            }
        }
        
        // Change main image when clicking thumbnail
        function changeMainImage(imageUrl) {
            const mainImage = document.querySelector('.w-full.h-96.object-cover.rounded-lg');
            if (mainImage) {
                mainImage.src = imageUrl;
            }
        }
        
        // Cart functionality
        let cart = [];
        
        // Toggle cart dropdown
        document.getElementById('cartButton').addEventListener('click', function() {
            const dropdown = document.getElementById('cartDropdown');
            dropdown.classList.toggle('hidden');
        });
        
        // Close cart dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const cartButton = document.getElementById('cartButton');
            const cartDropdown = document.getElementById('cartDropdown');
            
            if (!cartButton.contains(event.target) && !cartDropdown.contains(event.target)) {
                cartDropdown.classList.add('hidden');
            }
        });
        
        // Add item to cart - using the main function from welcome.js
        // The addToCart function is defined in welcome.js and handles all cart logic including modals
        
        // Update cart display
        function updateCartDisplay() {
            const cartCount = document.getElementById('cartCount');
            const cartItems = document.getElementById('cartItems');
            const cartTotalItems = document.getElementById('cartTotalItems');
            
            cartCount.textContent = cart.length;
            cartTotalItems.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            
            // Update cart items display
            cartItems.innerHTML = '';
            cart.forEach((item, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex justify-between items-center p-2 bg-gray-50 rounded';
                itemDiv.innerHTML = `
                    <div>
                        <span class="font-medium">${item.name}</span>
                        <span class="text-gray-500">x${item.quantity}</span>
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                cartItems.appendChild(itemDiv);
            });
        }
        
        // Remove item from cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }
        
        // Proceed to reservation
        document.getElementById('proceedToReservation').addEventListener('click', function() {
            if (cart.length === 0) {
                alert('Your cart is empty');
                return;
            }
            
            // Update modal cart items
            const modalCartItems = document.getElementById('modalCartItems');
            modalCartItems.innerHTML = '';
            cart.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.innerHTML = `<span>${item.name} x${item.quantity}</span>`;
                modalCartItems.appendChild(itemDiv);
            });
            
            // Set cart data for form submission
            document.getElementById('cartDataInput').value = JSON.stringify(cart);
            
            // Show modal
            document.getElementById('reservationModal').classList.remove('hidden');
            document.getElementById('cartDropdown').classList.add('hidden');
        });
        
        // Close reservation modal
        function closeReservationModal() {
            document.getElementById('reservationModal').classList.add('hidden');
        }
        
        // Set minimum return date based on borrow date
        document.getElementById('borrow_date').addEventListener('change', function() {
            const borrowDate = this.value;
            const returnDateInput = document.getElementById('return_date');
            const minReturnDate = new Date(borrowDate);
            minReturnDate.setDate(minReturnDate.getDate() + 1);
            returnDateInput.min = minReturnDate.toISOString().split('T')[0];
        });
        
        // Notification system
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            // Set notification styles based on type
            let bgColor, textColor, iconColor, icon;
            switch(type) {
                case 'success':
                    bgColor = 'bg-green-50';
                    textColor = 'text-green-800';
                    iconColor = 'text-green-400';
                    icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>`;
                    break;
                case 'error':
                    bgColor = 'bg-red-50';
                    textColor = 'text-red-800';
                    iconColor = 'text-red-400';
                    icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>`;
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-50';
                    textColor = 'text-yellow-800';
                    iconColor = 'text-yellow-400';
                    icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>`;
                    break;
                default:
                    bgColor = 'bg-blue-50';
                    textColor = 'text-blue-800';
                    iconColor = 'text-blue-400';
                    icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>`;
            }
            
            notification.className = `${bgColor} border border-gray-200 rounded-lg p-4 shadow-lg max-w-sm transform transition-all duration-300 ease-in-out translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="${iconColor}">${icon}</div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium ${textColor}">${message}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }

        @auth
        function addToWishlist(equipmentId, equipmentName) {
            console.log('Adding to wishlist:', equipmentId, equipmentName);
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            
            fetch(`/wishlist/add/${equipmentId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Show green themed modal instead of flash notification
                    Swal.fire({
                        icon: false,
                        html: `
                            <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Added to Wishlist</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">Equipment added to wishlist successfully!</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close();">
                                    OK
                                </button>
                            </div>
                        `,
                        showConfirmButton: false,
                        showCancelButton: false,
                        customClass: {
                            popup: 'swal-custom-popup'
                        }
                    });
                } else {
                    showNotification(data.message || 'Error adding to wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error adding to wishlist: ' + error.message, 'error');
            });
        }
        @endauth
    </script>
</body>
</html>

