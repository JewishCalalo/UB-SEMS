# SEMS - Sports Equipment Management System

A Laravel-based web application for managing sports equipment at the University of Baguio Physical Education Office. This README serves as both a system overview and a daily operational guide for developers/admins to monitor, maintain, and record updates.

## Features

### User Roles

#### 1. Users (Borrowers)
- Browse available/unavailable equipment
- Search, filter, and sort by category, availability, or keyword
- Add equipment to wishlist
- Reserve multiple items through a form with:
  - Name (auto-filled)
  - University email (@ubaguio.edu)
  - Contact number (optional)
  - Reason for reservation
- View reservation status (Pending, Approved, Denied, Completed)
- Receive email notifications for request updates
- View reservation history

#### 2. Managers
- Login to manage requests (approve, deny, add remarks)
- Manage categories and equipment inventory (CRUD)
- Track maintenance history and schedule next checks
- Mark damaged or lost equipment

#### 3. Admin
- Full access to all features
- Manage Manager accounts
- View comprehensive dashboard with:
  - Equipment utilization statistics
  - Top borrowed items
  - Pending requests
  - Overdue maintenance alerts
- Generate downloadable reports (PDF/Excel)
- Manage system settings (categories, roles, email templates)

### Key Features

- **Landing Page**: Equipment list with live availability, search/filter/sort, and details view
- **Reservation System**: Multi-item selection, form validation, email + in-app notifications
- **Inventory Management**: Categorized equipment, CRUD operations, multiple images, condition tracking
- **Maintenance Module**: Log maintenance history, upload proof, schedule next check
- **Reports**: Reservation trends, most borrowed items, damaged/missing list, overdue tracking
- **Notifications**: Approvals/denials, late returns, maintenance reminders
- **User Accounts**: University email verification, profile updates, history view

### Security Features

- Role-Based Access Control (RBAC)
- CSRF protection, input validation, and password hashing
- Email verification for all accounts
- Session timeout after inactivity
- Login attempt throttling to prevent brute-force attacks
- Audit logs for tracking actions
- HTTPS/SSL enforcement

## Tech Stack

- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade, Tailwind, Vite
- **Database**: SQLite (dev) / MySQL or PostgreSQL (prod)
- **Queue/Jobs**: Laravel queues (configurable)
- **Mail**: SMTP (Gmail/Mailtrap/University server), optional `resend/resend-laravel`
- **PDF/Reports**: `barryvdh/laravel-dompdf`
- **Scheduling**: Laravel Scheduler (cron)

## Project Structure Highlights

- `routes/web.php`: Web routes for guest, user, manager, and admin
- `app/Http/Controllers`: Feature controllers (equipment, reservations, maintenance, backups)
- `app/Console/Commands`: Operational commands (reservations, maintenance, backups)
- `app/Console/Schedule.php`: Scheduled tasks (backups, cleanup, reminders, reports)
- `resources/views`: Organized role-based views (see `VIEW_ORGANIZATION.md`)
- `config/sems.php`: System-level settings (backups, retention, timings)

## Operations & Monitoring

### Health Checks

- Web: visit home page `/` and dashboard routes by role
- Auth status API: `GET /api/check-auth`
- Scheduler list: `php artisan schedule:list`
- Logs: `storage/logs/laravel.log`, `storage/logs/security.log`

### Key Scheduled Jobs (see `app/Console/Schedule.php`)

- Daily DB backup: `backup:create --encrypt` at `SEMS_BACKUP_TIME` (default 02:00)
- Notifications cleanup: daily 03:00
- Activity logs cleanup: weekly Sunday 04:00
- Maintenance checks/reminders/enforcement: daily 09:00/10:00/11:00
- Reservations: mark expired (hourly), mark overdue (daily 08:00), send overdue reminders (daily 14:00)
- Reports: generate daily (23:00)
- DB optimize: weekly Sunday 05:00

To run scheduler once: `php artisan schedule:run`

### Backup Management

- Admin UI for manual backups and history at `/admin/database-backup`
- Console: `php artisan backup:create [--encrypt] [--description="..."]`
- Configure via `.env`:
  - `SEMS_AUTO_BACKUP_ENABLED=true`
  - `SEMS_BACKUP_RETENTION_DAYS=30`
  - `SEMS_BACKUP_TIME=02:00`
See `DATABASE_BACKUP_README.md` for full guide.

### Security Operations

- Cache-control middleware on auth routes
- Enhanced logout invalidates session and clears storage
- Frontend checks to prevent back-button access post-logout
See `SECURITY_IMPLEMENTATION.md` for details.

### Database Backup

- Daily automated backups via Laravel Scheduler
- Manual backup option in Admin Panel
- Cloud backup storage integration (Google Drive/AWS S3)
- Encrypted backups with retention policy
- One-click restore option

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL/PostgreSQL database
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd SEMS
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

2.1 **Windows one-step setup (enables GD, installs deps)**
   ```powershell
   Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass; ./scripts/setup.ps1
   ```
   - This runs `scripts/enable-gd.ps1`, then `composer install`, and generates the app key.
   - To skip Node deps now: `./scripts/setup.ps1 -NoNpm`
   - If serving via Apache/Nginx, restart the web server after running the script.
   - Verification
    ```bash
    php -m | grep -i gd 
    ```
   - If it prints “gd”, they’re good to go

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database in .env file**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sems_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database with sample data**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

### Email Configuration

Configure `.env` for SMTP. For Gmail App Passwords or Mailtrap, see `README_EMAIL_SETUP.md`.

## Default Accounts

Default credentials depend on which seeder you run. See `SEEDER_README.md` for exact emails and roles. The Minimal Test Data seeder creates:

- **Admin**: `20214200@s.ubaguio.edu` / `password`
- **Managers**: `99999999@e.ubaguio.edu`, `88888888@e.ubaguio.edu` / `password`
  
You can also create additional users via UI or seeders.

## Usage

### For Users
1. Register with a @ubaguio.edu email address
2. Browse available equipment
3. Add items to your reservation
4. Submit reservation request
5. Track status and receive notifications

### For Managers
1. Login with manager credentials
2. Approve/deny reservation requests
3. Manage equipment inventory
4. Update maintenance schedules

### For Admins
1. Login with admin credentials
2. Access admin dashboard at `/admin`
3. Manage all aspects of the system
4. Generate reports and analytics
5. Configure system settings

## API Endpoints

The system provides RESTful API endpoints for:
- Equipment management
- Reservation processing
- User management
- Reporting and analytics

## Roles & Modules (Implemented)

- **Users/Borrowers**: browse equipment, guest reservations, track reservations
- **Instructors**: dedicated dashboard, create/track reservations, incident reports, reports export (PDF)
- **Managers/Admins**:
  - Equipment Categories, Types, Equipment CRUD with images
  - Maintenance Management (records, routine/emergency enforcement, reports, exports)
  - Reservation Management (approve/decline/pickup/returns, calendar, pending/overdue, reports, PDF/Excel/CSV exports)
  - Equipment Pickup and Returns workflows (with instance history)
  - Missing Equipment Management (report, replace tracking, PDF/Excel export)
  - Blacklist Management
  - Activity Logs
  - Database Backups (create/download/restore/delete)

Security measures include cache-control middleware on authenticated routes and enhanced logout/session protection.

## Developer Daily Log

Use this section to record daily changes, migrations, commands run, and notes. Keep newest on top.

### 2025-10-02 → 2025-10-03
- Summary: Instructor module polish, report modal fixes, duplicate detection E2E verified, SweetAlert width governance, wishlist/guide UX improvements, admin/manager maintenance of icons/legends, database-backup UI cleanup, friendly error pages, and multiple UI consistency passes across modals and buttons.
- Code changes (highlights):
  - Instructor Dashboard & Pages
    - `resources/views/instructor/dashboard.blade.php`: Modernized statistics cards; unified Quick Actions design (Create Reservation card updated to match others; note: cache/asset rebuild may be required for stale styles).
    - `resources/views/instructor/reservations/create.blade.php`: UI/UX polish (search with icon, availability badges, improved quantity controls, softened unavailable cards); client-side validation for dates/times/purpose; AJAX submission with success modal; duplicate-check flow with orange confirm modal.
    - `resources/views/instructor/reservations/index.blade.php`: Generate Report modal rebuilt with green banner header, spacing fix, and consistent buttons.
  - Track Reservation Page (user):
    - `resources/views/user/reservations/track.blade.php`: Edit Reservation modal redesign (blue header, centered title, subtitle, sticky summary on desktop, mobile-friendly); hide unavailable items; search alignment; fixed-width “Add”; Undo restores snapshot; success modal with green header.
  - SweetAlert2 Sizing & Styles:
    - `resources/css/sweetalert2-custom.css`: Base popup width for simple alerts; dedicated classes for Welcome, Complete Reservation, Edit Reservation; scrollable content; mobile fluidity tweaks.
  - Welcome / Complete Reservation UX:
    - `resources/js/components/welcome.js`: Borrow date limited to today..+6 days; time rules (8:00–17:00, no past on today, +30min same‑day); restructured form into sections; Welcome guide always shown on `/` with larger width; updated copy (Verify Email, Approval & Pickup), submit icon corrected.
  - Wishlist & Grid Button:
    - `resources/views/components/equipment-grid.blade.php`: Swapped heart → star; purple theme; spacing fixes; “Add to Wishlist” labeling restored.
  - Equipment Creation (Admin/Manager):
    - `resources/views/(admin|manager)/equipment-management/create.blade.php`: Inline per-field validation, disabled submit until valid; required Acquisition Date/Location; future-date warning; condition options limited; duplicate error card; suppressed generic list on duplicate.
    - `app/Http/Requests/Equipment/EquipmentStoreRequest.php`: Rules aligned (required fields, condition in excellent/good/fair).
    - `app/Http/Controllers/EquipmentManagementController.php`: Duplicate detection (brand+model+category+type), flash success title; success banner uses green header.
  - Success/Deletion Modals:
    - `resources/views/layouts/app.blade.php`: Global success SweetAlert uses green header/title; removed extra OK button.
    - `resources/views/(admin|manager)/equipment-management/show.blade.php`: Deletion success OK button matches green header.
  - Friendly Error Pages:
    - `resources/views/errors/{403,404,429,500}.blade.php`: New consistent designs.
  - Maintenance & Database Backup UI:
    - `resources/views/(admin|manager)/maintenance-management/index.blade.php`: Plus icon for add; action legend spacing redistributed.
    - `resources/views/(admin|manager)/equipment-management/index.blade.php`: Wrench icons standardized across legends/actions.
    - `resources/views/admin/database-backup/index.blade.php`: Removed download action; redistributed legend columns.
    - `routes/web.php`, `app/Http/Controllers/DatabaseBackupController.php`: Removed download route/action.
  - Guest flows:
    - `resources/views/user/reservations/guest-confirmation.blade.php`: After cancel, redirect home; improved copy-to-clipboard button.
  - Wishlist Analytics (Admin/Manager):
    - `resources/views/(admin|manager)/equipment-management/wishlisted.blade.php`: Summary cards (Total, Available, Unavailable, Avg); charts (Top Wishlisted, Category Distribution, Availability) with Chart.js.
  - Auth & Error Cards:
    - `resources/views/auth/login.blade.php`: Removed HTML validations; global error card at top with friendly message.
- Migrations: none
- Seeders: none
- Commands run:
  - `npm run build` (after CSS/JS changes)
- Notes/Risks:
  - Quick Actions Create Reservation card may look stale until cache is cleared or assets are rebuilt (`npm run build`).
  - External fonts can log CORS in local dev; consider local font stack.

### 2025-10-01
- Summary: Broad UI/UX overhaul and validation work. Rebuilt Edit Reservation modal, standardized SweetAlert2 styles, made modals responsive, improved equipment creation UX, added user‑friendly error pages, and refined welcome/guide experiences.
- Code changes:
  - Track page and Edit Reservation
    - `resources/views/user/reservations/track.blade.php`: Rebuilt Edit Reservation modal (centered blue header with subtitle, edge‑to‑edge header, custom width, sticky summary on desktop, stacked layout on mobile). Added Undo (restores original items), success modal with green header, search alignment, hide unavailable items, simplified summary, fixed‑width “Add” button, responsive cancel button label (mobile “Cancel”, desktop “Cancel Reservation”). Enhanced empty summary handling with confirmation flow.
    - `resources/css/sweetalert2-custom.css`: System‑wide SweetAlert2 responsive rules (`.swal-custom-popup` sizing, scrollable content, reduced container padding on small screens). Dedicated sizing for `.swal-edit-reservation`. Single‑column grid below 640px; sticky disabled below 1024px.
  - Equipment creation (Admin/Manager)
    - `app/Http/Requests/Equipment/EquipmentStoreRequest.php`: Required fields, `condition` restricted to `excellent,good,fair`, `purchase_date` and `location` required.
    - `app/Http/Controllers/EquipmentManagementController.php`: Duplicate check (brand+model+category+type) returns error with `duplicate` key and `withInput()`. Success modal uses `success_title`.
    - `resources/views/admin/equipment-management/create.blade.php` and `resources/views/manager/equipment-management/create.blade.php`: Inline validation for all required fields; disable submit until valid; removed Active checkbox; condition options limited; acquisition date future‑date warning; duplicate error card (single source of truth, suppress generic list on duplicate).
  - Success and deletion modals
    - `resources/views/layouts/app.blade.php`: Global success SweetAlert uses green header/title via `session('success_title')`; fixed duplicate OK button.
    - `resources/views/(admin|manager)/equipment-management/show.blade.php`: Deletion success OK button styled to match green header.
  - User‑friendly error pages
    - `resources/views/errors/403.blade.php`, `404.blade.php`, `429.blade.php`, `500.blade.php`: Added consistent, user‑friendly pages aligned with session timeout style.
  - Welcome/Reservation UX
    - `resources/js/components/welcome.js`: Borrow date limited to today + 6 days; time validation (8:00–17:00, no past times, +30 min same‑day); rebuilt Complete Your Reservation modal groupings (Personal Details, Date & Time, Reservation & Additional Details) and separated How It Works; widened guide; content updates (Verify Email text, Approval & Pickup copy); Welcome to SEMS guide shown reliably and sized to match main modal.
    - `resources/css/sweetalert2-custom.css`: `.swal-custom-popup` max‑width extended to allow wider Welcome and Reservation modals.
  - Reservations flow
    - `resources/views/user/reservations/guest-confirmation.blade.php`: After cancel, redirect to home.
    - `routes/web.php`: Ensured POST cancel route maps to `ReservationController@cancel`.
- Migrations: none
- Seeders: none
- Commands run:
  - `npm run build` (rebuild assets after CSS/JS changes)
- Backups: none
- Notes/Risks:
  - External font (Bunny Fonts Figtree) may trigger CORS in local dev; consider self‑hosting or a local fallback stack.
  - Re-check all SweetAlert2 modals app‑wide for consistent width/scroll on mobile to avoid regressions.

### Template (copy for each day)
- Summary: short description of changes
- Code changes: files/areas touched
- Migrations: list IDs if any
- Seeders: which ran
- Commands run: list commands
- Backups: created/restored? description
- Notes/Risks: rollbacks, follow-ups

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please contact the development team or create an issue in the repository.

## Changelog

### Version 1.0.0
- Initial release
- Basic equipment management
- Reservation system
- User role management
- Admin dashboard
- Basic reporting


