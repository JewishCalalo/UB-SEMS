# SEMS Minimal Test Data Seeder

This seeder provides minimal test data for the SEMS (Sports Equipment Management System) application, following all form validation rules and requirements.

## 🚀 Quick Start

### Run the Seeder
```bash
# Seed with existing data (recommended)
php artisan seed:minimal-test-data

# Seed with fresh database (removes all existing data)
php artisan seed:minimal-test-data --fresh
```

### Alternative Methods
```bash
# Using Laravel's default seeder
php artisan db:seed --class=MinimalTestDataSeeder

# Run all seeders (including UserSeeder)
php artisan db:seed
```

## 📊 Test Data Overview

### Users (3 total)
- **1 Admin User**
  - Email: `20214200@s.ubaguio.edu`
  - Password: `password`
  - Role: `admin`
  - Department: `IT Department`

- **2 Manager Users**
  - Email: `99999999@e.ubaguio.edu` (Manager User)
  - Email: `88888888@e.ubaguio.edu` (Sports Manager)
  - Password: `password`
  - Role: `manager`
  - Departments: `Physical Education Office`, `Sports Development Office`

### Equipment Categories (5 total)
- Basketball
- Tennis
- Volleyball
- Badminton
- Table Tennis

### Equipment Types (15 total)
Each category has 3 equipment types:

**Basketball:**
- Ball
- Jersey
- Shoes

**Tennis:**
- Racket
- Ball
- Net

**Volleyball:**
- Ball
- Net
- Knee Pads

**Badminton:**
- Racket
- Shuttlecock
- Net

**Table Tennis:**
- Paddle
- Ball
- Table

### Equipment Items (6 total)
- Spalding Basketball (5 instances)
- Wilson Basketball (5 instances)
- Wilson Pro Staff Racket (3 instances)
- Head Speed Racket (3 instances)
- Mikasa Volleyball (4 instances)
- Yonex Badminton Racket (6 instances)
- Butterfly Table Tennis Paddle (8 instances)

## ✅ Validation Compliance

### User Data
- ✅ **Email Format**: Follows Ubaguio email pattern (`XXXXXXXX@s.ubaguio.edu` or `XXXXXXXX@e.ubaguio.edu`)
- ✅ **Password**: Minimum 8 characters, hashed with Laravel's Hash facade
- ✅ **Role**: Only `admin` and `manager` roles (no regular users)
- ✅ **Contact Number**: Valid phone number format
- ✅ **Department**: Realistic department names
- ✅ **Address**: Complete address information
- ✅ **Email Verification**: All users are email verified
- ✅ **Active Status**: All users are active

### Equipment Categories
- ✅ **Name**: Unique, descriptive names
- ✅ **Description**: Detailed descriptions (max 1000 characters)
- ✅ **Active Status**: All categories are active
- ✅ **No Duplicates**: Case-insensitive duplicate prevention

### Equipment Types
- ✅ **Category Association**: Each type belongs to a valid category
- ✅ **Name**: Unique within category, descriptive names
- ✅ **Description**: Detailed descriptions (max 1000 characters)
- ✅ **No Duplicates**: Case-insensitive duplicate prevention within category

### Equipment Items
- ✅ **Name**: Descriptive equipment names
- ✅ **Category & Type**: Valid associations
- ✅ **Brand & Model**: Realistic brand and model information
- ✅ **Condition**: Valid conditions (`excellent`, `good`, `fair`, `needs_repair`, `damaged`)
- ✅ **Location**: Realistic storage locations
- ✅ **Purchase Date**: Valid dates
- ✅ **Created By**: Valid user ID
- ✅ **Quantity**: Realistic quantities per equipment type

### Equipment Instances
- ✅ **Instance Codes**: Unique, formatted codes (e.g., `BAS-001`, `TEN-001`)
- ✅ **Condition Distribution**: Weighted distribution (40% excellent, 35% good, 15% fair, 7% needs_repair, 3% damaged)
- ✅ **Availability**: Based on condition (damaged/needs_repair items are unavailable)
- ✅ **Location**: Inherited from parent equipment
- ✅ **Maintenance Dates**: Set for excellent condition items

## 🔧 Technical Details

### Database Relationships
- Users → Equipment (created_by)
- Equipment Categories → Equipment Types
- Equipment Types → Equipment
- Equipment → Equipment Instances

### Instance Code Generation
- Format: `CAT-001` (3-letter category prefix + sequential number)
- Uniqueness: Ensured across all instances
- Examples: `BAS-001`, `TEN-001`, `VOL-001`, `BAD-001`, `TAB-001`

### Condition Distribution
- **Excellent (40%)**: Like new condition, no issues
- **Good (35%)**: Minor wear, fully functional
- **Fair (15%)**: Some wear and tear, still usable
- **Needs Repair (7%)**: Requires maintenance before use
- **Damaged (3%)**: Significant damage, needs replacement

## 🎯 Use Cases

### Testing Scenarios
1. **User Management**: Test admin/manager role differences
2. **Equipment Management**: Test CRUD operations on categories, types, and equipment
3. **Instance Management**: Test equipment instance tracking
4. **Condition Tracking**: Test different equipment conditions
5. **Availability Logic**: Test available vs. unavailable equipment

### Development
- **Form Validation**: All data follows form validation rules
- **UI Testing**: Sufficient data for testing pagination, search, and filters
- **Feature Testing**: Enough variety to test all system features

## 🚫 What's NOT Included

- **Reservations**: No reservation data (as requested)
- **Missing Equipment**: No missing equipment records
- **Maintenance Records**: No maintenance history
- **Return Logs**: No return log entries
- **Wishlists**: No wishlist data

## 🔄 Re-running the Seeder

The seeder is designed to be **idempotent** - it can be run multiple times safely:
- Uses `updateOrCreate()` for users, categories, types, and equipment
- Checks for existing instances before creating new ones
- Prevents duplicate data creation

## 📝 Notes

- All passwords are set to `password` for easy testing
- Email addresses follow the exact Ubaguio format required by validation
- Equipment quantities are realistic for a sports equipment management system
- Instance codes are generated following the system's naming convention
- All data follows the application's validation rules and constraints
