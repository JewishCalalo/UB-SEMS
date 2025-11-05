# Entity-Relationship Diagram (ERD) for SEMS System

This document provides a textual representation of the Entity-Relationship Diagram for the SEMS (likely School Equipment Management System) based on the Laravel application's models and database migrations.

## Entities and Attributes

### 1. Users
- **Attributes**: id (PK), name, email (unique), email_verified_at, password, role (enum: user/manager/admin), contact_number, department, is_verified, two_factor_enabled, two_factor_secret, last_activity, remember_token, created_at, updated_at

### 2. EquipmentCategories
- **Attributes**: id (PK), name, description, icon, is_active, created_at, updated_at

### 3. EquipmentTypes
- **Attributes**: id (PK), category_id (FK to EquipmentCategories), name, description, created_at, updated_at
- **Unique Constraint**: (category_id, name)

### 4. Equipment
- **Attributes**: id (PK), name, category_id (FK to EquipmentCategories), equipment_type_id (FK to EquipmentTypes, nullable), description, brand, model, serial_number, quantity_total, quantity_available, condition (enum), location, purchase_price, purchase_date, last_maintenance_date, next_maintenance_date, is_active, created_by (FK to Users), created_at, updated_at

### 5. EquipmentImages
- **Attributes**: id (PK), equipment_id (FK to Equipment), image_path, is_primary, created_at, updated_at

### 6. EquipmentInstances
- **Attributes**: id (PK), equipment_id (FK to Equipment), instance_code (unique), condition (enum), condition_notes, location, is_available, is_active, last_maintenance_date, next_maintenance_date, created_at, updated_at

### 7. Reservations
- **Attributes**: id (PK), reservation_code (unique), user_id (FK to Users, nullable), borrow_date, return_date, status (enum), reason, additional_details, remarks, approved_by (FK to Users, nullable), approved_at, pickup_date, picked_up_at, returned_at, created_at, updated_at

### 8. ReservationItems
- **Attributes**: id (PK), reservation_id (FK to Reservations), equipment_id (FK to Equipment), quantity_requested, quantity_approved, created_at, updated_at

### 9. ReservationItemInstances
- **Attributes**: id (PK), reservation_item_id (FK to ReservationItems), equipment_instance_id (FK to EquipmentInstances), status, picked_up_at, returned_at, created_at, updated_at
- **Unique Constraint**: (reservation_item_id, equipment_instance_id)

### 10. MaintenanceRecords
- **Attributes**: id (PK), equipment_id (FK to Equipment), equipment_instance_id (FK to EquipmentInstances, nullable), performed_by (FK to Users), maintenance_date, maintenance_type (enum), description, notes, created_at, updated_at

### 11. ReturnLogs
- **Attributes**: id (PK), reservation_id (FK to Reservations), equipment_instance_id (FK to EquipmentInstances), returned_condition (enum), condition_notes, quantity_returned, quantity_damaged, quantity_lost, damage_description, processed_by (FK to Users), returned_at, created_at, updated_at

### 12. Wishlists
- **Attributes**: id (PK), equipment_id (FK to Equipment), wishlist_count, created_at, updated_at
- **Unique Constraint**: equipment_id

### 13. MissingEquipment
- **Attributes**: id (PK), equipment_instance_id (FK to EquipmentInstances), reservation_id (FK to Reservations, nullable), borrower_name, borrower_email, borrower_contact_number, borrower_department, incident_date, incident_type (enum), incident_description, replacement_status (enum), replacement_date, acted_by (FK to Users, nullable), acted_at, created_at, updated_at

### 14. InstanceRetirements
- **Attributes**: id (PK), equipment_instance_id (FK to EquipmentInstances), reason, notes, acted_by (FK to Users, nullable), acted_at, created_at, updated_at

## Relationships

### One-to-Many Relationships
- **Users** --1:N--> **Reservations** (user_id)
- **Users** --1:N--> **Reservations** (approved_by)
- **Users** --1:N--> **Equipment** (created_by)
- **Users** --1:N--> **MaintenanceRecords** (performed_by)
- **Users** --1:N--> **ReturnLogs** (processed_by)
- **Users** --1:N--> **InstanceRetirements** (acted_by)
- **EquipmentCategories** --1:N--> **Equipment** (category_id)
- **EquipmentCategories** --1:N--> **EquipmentTypes** (category_id)
- **EquipmentTypes** --1:N--> **Equipment** (equipment_type_id)
- **Equipment** --1:N--> **EquipmentImages** (equipment_id)
- **Equipment** --1:N--> **MaintenanceRecords** (equipment_id)
- **Equipment** --1:N--> **ReservationItems** (equipment_id)
- **Equipment** --1:N--> **EquipmentInstances** (equipment_id)
- **Equipment** --1:N--> **Wishlists** (equipment_id)
- **EquipmentInstances** --1:N--> **ReturnLogs** (equipment_instance_id)
- **EquipmentInstances** --1:N--> **MaintenanceRecords** (equipment_instance_id)
- **EquipmentInstances** --1:N--> **InstanceRetirements** (equipment_instance_id)
- **EquipmentInstances** --1:N--> **MissingEquipment** (equipment_instance_id)
- **Reservations** --1:N--> **ReservationItems** (reservation_id)
- **Reservations** --1:N--> **ReturnLogs** (reservation_id)
- **Reservations** --1:N--> **MissingEquipment** (reservation_id)
- **ReservationItems** --1:N--> **ReservationItemInstances** (reservation_item_id)

### Many-to-Many Relationships
- **Reservations** --N:M--> **Equipment** (through ReservationItems: reservation_id, equipment_id)

### One-to-One Relationships
- None identified

### Belongs-To Relationships (Reverse of One-to-Many)
- **EquipmentTypes** <-- **EquipmentCategories** (category_id)
- **Equipment** <-- **EquipmentCategories** (category_id)
- **Equipment** <-- **EquipmentTypes** (equipment_type_id)
- **Equipment** <-- **Users** (created_by)
- **EquipmentImages** <-- **Equipment** (equipment_id)
- **EquipmentInstances** <-- **Equipment** (equipment_id)
- **Reservations** <-- **Users** (user_id)
- **Reservations** <-- **Users** (approved_by)
- **ReservationItems** <-- **Reservations** (reservation_id)
- **ReservationItems** <-- **Equipment** (equipment_id)
- **ReservationItemInstances** <-- **ReservationItems** (reservation_item_id)
- **ReservationItemInstances** <-- **EquipmentInstances** (equipment_instance_id)
- **MaintenanceRecords** <-- **Equipment** (equipment_id)
- **MaintenanceRecords** <-- **EquipmentInstances** (equipment_instance_id)
- **MaintenanceRecords** <-- **Users** (performed_by)
- **ReturnLogs** <-- **Reservations** (reservation_id)
- **ReturnLogs** <-- **EquipmentInstances** (equipment_instance_id)
- **ReturnLogs** <-- **Users** (processed_by)
- **Wishlists** <-- **Equipment** (equipment_id)
- **InstanceRetirements** <-- **EquipmentInstances** (equipment_instance_id)
- **InstanceRetirements** <-- **Users** (acted_by)
- **MissingEquipment** <-- **EquipmentInstances** (equipment_instance_id)
- **MissingEquipment** <-- **Reservations** (reservation_id)
- **MissingEquipment** <-- **Users** (acted_by)

## Additional Notes
- All tables have `id` as primary key (auto-incrementing).
- Foreign keys are enforced with appropriate cascade or set null actions.
- Some fields are nullable as indicated.
- The system manages equipment reservations, maintenance, returns, and retirements in an educational or organizational context.
- Equipment can have multiple instances, allowing for tracking individual items.
- Reservations can include multiple equipment items with quantities.
- Maintenance and return processes are logged with details.

This ERD provides a comprehensive overview of the database structure and relationships in the SEMS application.
