# Database Restore Instructions

## Issue
When restoring database backups, the users table may revert to an old schema with a CHECK constraint that only allows roles: 'user', 'manager', 'admin' but NOT 'instructor'.

## Solution
After restoring any database backup, run one of these commands to fix the constraint:

### Option 1: Run the Artisan Command (Recommended)
```bash
php artisan fix:users-role-constraint
```

### Option 2: Run Migrations
```bash
php artisan migrate
```

## What the Fix Does
- Removes the restrictive CHECK constraint on the role field
- Allows 'instructor' as a valid role
- Preserves all existing user data
- Tests the fix by creating a test user

## Verification
The command will automatically test user creation and show success/error messages.

## Prevention
The migration `2025_09_13_193516_ensure_users_role_constraint_fixed.php` will automatically detect and fix this issue when running migrations.

## Manual Fix (if needed)
If the automated fixes don't work, you can manually run the database fix script:

```php
// In tinker or a PHP script
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Drop temp tables
DB::statement('DROP TABLE IF EXISTS users_temp');
DB::statement('DROP TABLE IF EXISTS users_new');

// Create new table without CHECK constraint
DB::statement('CREATE TABLE users_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    email VARCHAR NOT NULL UNIQUE,
    email_verified_at DATETIME,
    password VARCHAR NOT NULL,
    role VARCHAR NOT NULL DEFAULT "instructor",
    contact_number VARCHAR,
    department VARCHAR,
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    two_factor_enabled TINYINT(1) NOT NULL DEFAULT 0,
    two_factor_secret TEXT,
    last_activity DATETIME,
    remember_token VARCHAR,
    created_at DATETIME,
    updated_at DATETIME
)');

// Copy data
DB::statement('INSERT INTO users_new SELECT * FROM users');

// Replace old table
DB::statement('DROP TABLE users');
DB::statement('ALTER TABLE users_new RENAME TO users');
```
