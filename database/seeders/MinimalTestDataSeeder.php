<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\EquipmentCategory;
use App\Models\EquipmentType;
use App\Models\Equipment;
use App\Models\EquipmentInstance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MinimalTestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Users are seeded separately in UserSeeder
        
        // Create Equipment Categories
        $this->createEquipmentCategories();
        
        // Create Equipment Types
        $this->createEquipmentTypes();
        
        // Create Equipment with Instances
        $this->createEquipmentWithInstances();
    }

    private function createUsers(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => '20214200@s.ubaguio.edu'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
                'contact_number' => '09123456789',
                'department' => 'IT Department',
                'address' => '123 Admin Street, Baguio City',
            ]
        );

        // Manager User
        User::updateOrCreate(
            ['email' => '99999999@e.ubaguio.edu'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
                'is_active' => true,
                'contact_number' => '09876543210',
                'department' => 'Physical Education Office',
                'address' => '456 Manager Avenue, Baguio City',
            ]
        );

        // Additional Manager for testing
        User::updateOrCreate(
            ['email' => '88888888@e.ubaguio.edu'],
            [
                'name' => 'Sports Manager',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
                'is_active' => true,
                'contact_number' => '09765432109',
                'department' => 'Sports Development Office',
                'address' => '789 Sports Complex, Baguio City',
            ]
        );
    }

    private function createEquipmentCategories(): void
    {
        $categories = [
            [
                'name' => 'Basketball',
                'description' => 'Equipment and accessories for basketball activities',
                'is_active' => true,
            ],
            [
                'name' => 'Tennis',
                'description' => 'Equipment and accessories for tennis activities',
                'is_active' => true,
            ],
            [
                'name' => 'Volleyball',
                'description' => 'Equipment and accessories for volleyball activities',
                'is_active' => true,
            ],
            [
                'name' => 'Badminton',
                'description' => 'Equipment and accessories for badminton activities',
                'is_active' => true,
            ],
            [
                'name' => 'Table Tennis',
                'description' => 'Equipment and accessories for table tennis activities',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            EquipmentCategory::updateOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
        }
    }

    private function createEquipmentTypes(): void
    {
        $basketballCategory = EquipmentCategory::where('name', 'Basketball')->first();
        $tennisCategory = EquipmentCategory::where('name', 'Tennis')->first();
        $volleyballCategory = EquipmentCategory::where('name', 'Volleyball')->first();
        $badmintonCategory = EquipmentCategory::where('name', 'Badminton')->first();
        $tableTennisCategory = EquipmentCategory::where('name', 'Table Tennis')->first();

        $equipmentTypes = [
            // Basketball Equipment Types
            [
                'category_id' => $basketballCategory->id,
                'name' => 'Ball',
                'description' => 'Official basketball for games and practice',
            ],
            [
                'category_id' => $basketballCategory->id,
                'name' => 'Jersey',
                'description' => 'Team jerseys for basketball games',
            ],
            [
                'category_id' => $basketballCategory->id,
                'name' => 'Shoes',
                'description' => 'Basketball shoes for players',
            ],

            // Tennis Equipment Types
            [
                'category_id' => $tennisCategory->id,
                'name' => 'Racket',
                'description' => 'Tennis rackets for playing',
            ],
            [
                'category_id' => $tennisCategory->id,
                'name' => 'Ball',
                'description' => 'Tennis balls for games and practice',
            ],
            [
                'category_id' => $tennisCategory->id,
                'name' => 'Net',
                'description' => 'Tennis nets for court setup',
            ],

            // Volleyball Equipment Types
            [
                'category_id' => $volleyballCategory->id,
                'name' => 'Ball',
                'description' => 'Official volleyball for games and practice',
            ],
            [
                'category_id' => $volleyballCategory->id,
                'name' => 'Net',
                'description' => 'Volleyball nets for court setup',
            ],
            [
                'category_id' => $volleyballCategory->id,
                'name' => 'Knee Pads',
                'description' => 'Protective knee pads for players',
            ],

            // Badminton Equipment Types
            [
                'category_id' => $badmintonCategory->id,
                'name' => 'Racket',
                'description' => 'Badminton rackets for playing',
            ],
            [
                'category_id' => $badmintonCategory->id,
                'name' => 'Shuttlecock',
                'description' => 'Badminton shuttlecocks for games',
            ],
            [
                'category_id' => $badmintonCategory->id,
                'name' => 'Net',
                'description' => 'Badminton nets for court setup',
            ],

            // Table Tennis Equipment Types
            [
                'category_id' => $tableTennisCategory->id,
                'name' => 'Paddle',
                'description' => 'Table tennis paddles for playing',
            ],
            [
                'category_id' => $tableTennisCategory->id,
                'name' => 'Ball',
                'description' => 'Table tennis balls for games',
            ],
            [
                'category_id' => $tableTennisCategory->id,
                'name' => 'Table',
                'description' => 'Table tennis tables for playing',
            ],
        ];

        foreach ($equipmentTypes as $typeData) {
            EquipmentType::updateOrCreate(
                [
                    'category_id' => $typeData['category_id'],
                    'name' => $typeData['name'],
                ],
                $typeData
            );
        }
    }

    private function createEquipmentWithInstances(): void
    {
        $admin = User::where('email', '20214200@s.ubaguio.edu')->first();
        if (!$admin) {
            $admin = User::firstOrCreate(
                ['email' => '20214200@s.ubaguio.edu'],
                [
                    'name' => 'Admin User',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                    'is_verified' => true,
                    'contact_number' => '09123456789',
                    'department' => 'IT Department',
                ]
            );
        }
        
        // Get equipment types
        $basketballBall = EquipmentType::whereHas('category', function($q) {
            $q->where('name', 'Basketball');
        })->where('name', 'Ball')->first();

        $tennisRacket = EquipmentType::whereHas('category', function($q) {
            $q->where('name', 'Tennis');
        })->where('name', 'Racket')->first();

        $volleyballBall = EquipmentType::whereHas('category', function($q) {
            $q->where('name', 'Volleyball');
        })->where('name', 'Ball')->first();

        $badmintonRacket = EquipmentType::whereHas('category', function($q) {
            $q->where('name', 'Badminton');
        })->where('name', 'Racket')->first();

        $tableTennisPaddle = EquipmentType::whereHas('category', function($q) {
            $q->where('name', 'Table Tennis');
        })->where('name', 'Paddle')->first();

        $equipmentData = [
            // Basketball Equipment
            [
                'category_id' => $basketballBall->category_id,
                'equipment_type_id' => $basketballBall->id,
                'description' => 'Official Spalding basketball for indoor games',
                'brand' => 'Spalding',
                'model' => 'TF-1000',
                'condition' => 'excellent',
                'location' => 'Gymnasium A',
                'purchase_date' => '2024-01-15',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'category_id' => $basketballBall->category_id,
                'equipment_type_id' => $basketballBall->id,
                'description' => 'Wilson basketball for outdoor practice',
                'brand' => 'Wilson',
                'model' => 'Evolution',
                'condition' => 'good',
                'location' => 'Outdoor Court',
                'purchase_date' => '2024-02-20',
                'is_active' => true,
                'created_by' => $admin->id,
            ],

            // Tennis Equipment
            [
                'category_id' => $tennisRacket->category_id,
                'equipment_type_id' => $tennisRacket->id,
                'description' => 'Professional tennis racket for advanced players',
                'brand' => 'Wilson',
                'model' => 'Pro Staff 97',
                'condition' => 'excellent',
                'location' => 'Tennis Court 1',
                'purchase_date' => '2024-01-10',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
            [
                'category_id' => $tennisRacket->category_id,
                'equipment_type_id' => $tennisRacket->id,
                'description' => 'Head Speed racket for intermediate players',
                'brand' => 'Head',
                'model' => 'Speed MP',
                'condition' => 'good',
                'location' => 'Tennis Court 2',
                'purchase_date' => '2024-03-05',
                'is_active' => true,
                'created_by' => $admin->id,
            ],

            // Volleyball Equipment
            [
                'category_id' => $volleyballBall->category_id,
                'equipment_type_id' => $volleyballBall->id,
                'description' => 'Official Mikasa volleyball for competitions',
                'brand' => 'Mikasa',
                'model' => 'MVA200',
                'condition' => 'excellent',
                'location' => 'Volleyball Court',
                'purchase_date' => '2024-01-25',
                'is_active' => true,
                'created_by' => $admin->id,
            ],

            // Badminton Equipment
            [
                'category_id' => $badmintonRacket->category_id,
                'equipment_type_id' => $badmintonRacket->id,
                'description' => 'Yonex badminton racket for professional play',
                'brand' => 'Yonex',
                'model' => 'Astrox 99',
                'condition' => 'excellent',
                'location' => 'Badminton Court 1',
                'purchase_date' => '2024-02-10',
                'is_active' => true,
                'created_by' => $admin->id,
            ],

            // Table Tennis Equipment
            [
                'category_id' => $tableTennisPaddle->category_id,
                'equipment_type_id' => $tableTennisPaddle->id,
                'description' => 'Butterfly paddle for competitive table tennis',
                'brand' => 'Butterfly',
                'model' => 'Viscaria',
                'condition' => 'excellent',
                'location' => 'Table Tennis Room',
                'purchase_date' => '2024-01-30',
                'is_active' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($equipmentData as $equipmentInfo) {
            $equipment = Equipment::updateOrCreate(
                [
                    'category_id' => $equipmentInfo['category_id'],
                    'equipment_type_id' => $equipmentInfo['equipment_type_id'],
                    'brand' => $equipmentInfo['brand'],
                    'model' => $equipmentInfo['model'],
                ],
                $equipmentInfo
            );

            // Create instances for each equipment
            $this->createEquipmentInstances($equipment);
        }
    }

    private function createEquipmentInstances(Equipment $equipment): void
    {
        // Check if instances already exist for this equipment
        $existingInstances = EquipmentInstance::where('equipment_id', $equipment->id)->count();
        if ($existingInstances > 0) {
            return; // Skip if instances already exist
        }

        // Determine quantity based on equipment type
        $quantity = $this->getQuantityForEquipment($equipment);
        
        // Create instances
        for ($i = 0; $i < $quantity; $i++) {
            $condition = $this->getRandomCondition();
            $isAvailable = !in_array($condition, ['damaged', 'needs_repair', 'lost']);
            
            // Generate unique instance code
            $instanceCode = $this->generateUniqueInstanceCode($equipment);
            
            EquipmentInstance::create([
                'equipment_id' => $equipment->id,
                'instance_code' => $instanceCode,
                'condition' => $condition,
                'condition_notes' => $this->getConditionNotes($condition),
                'location' => $equipment->location,
                'is_available' => $isAvailable,
                'is_active' => true,
                'last_maintenance_date' => $condition === 'excellent' ? now()->subDays(30) : null,
            ]);
        }
    }

    private function generateUniqueInstanceCode(Equipment $equipment): string
    {
        // Get category abbreviation (first 3 letters of category name)
        $categoryPrefix = strtoupper(substr($equipment->category->name, 0, 3));
        
        // Get sequential number for this equipment type
        $count = EquipmentInstance::where('equipment_id', $equipment->id)->count() + 1;
        
        // Format: CAT-001 (3 letters + dash + 3 numbers)
        $baseCode = $categoryPrefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        
        // Ensure uniqueness by checking if code already exists
        $instanceCode = $baseCode;
        $counter = 1;
        while (EquipmentInstance::where('instance_code', $instanceCode)->exists()) {
            $instanceCode = $baseCode . '-' . $counter;
            $counter++;
        }
        
        return $instanceCode;
    }

    private function getQuantityForEquipment(Equipment $equipment): int
    {
        $signature = strtolower(trim(($equipment->brand ?? '') . ' ' . ($equipment->model ?? '')));
        switch ($signature) {
            case 'spalding tf-1000':
            case 'wilson evolution':
                return 5; // 5 basketballs
            case 'wilson pro staff 97':
            case 'head speed mp':
                return 3; // 3 tennis rackets each
            case 'mikasa mva200':
                return 4; // 4 volleyballs
            case 'yonex astrox 99':
                return 6; // 6 badminton rackets
            case 'butterfly viscaria':
                return 8; // 8 table tennis paddles
            default:
                return 2; // Default quantity
        }
    }

    private function getRandomCondition(): string
    {
        $conditions = ['excellent', 'good', 'fair', 'needs_repair', 'damaged'];
        $weights = [40, 35, 15, 7, 3]; // Weighted distribution
        
        $random = mt_rand(1, 100);
        $cumulative = 0;
        
        for ($i = 0; $i < count($conditions); $i++) {
            $cumulative += $weights[$i];
            if ($random <= $cumulative) {
                return $conditions[$i];
            }
        }
        
        return 'good'; // Fallback
    }

    private function getConditionNotes(string $condition): ?string
    {
        $notes = [
            'excellent' => 'Like new condition, no issues',
            'good' => 'Minor wear, fully functional',
            'fair' => 'Some wear and tear, still usable',
            'needs_repair' => 'Requires maintenance before use',
            'damaged' => 'Significant damage, needs replacement',
        ];
        
        return $notes[$condition] ?? null;
    }
}
