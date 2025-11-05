# Database Backup System - SEMS

## Overview

The SEMS (Sports Equipment Management System) includes a comprehensive database backup solution that provides both manual and automated backup capabilities. This system ensures data safety and allows for quick recovery in case of system failures or data corruption.

## Features

### 🔒 **Security Features**
- **Encrypted Backups**: All backups are encrypted using Laravel's built-in encryption
- **Secure Storage**: Backups stored in protected storage directory
- **Access Control**: Only admin users can access backup management
- **Audit Logging**: All backup operations are logged for security tracking

### 📊 **Backup Management**
- **Manual Backups**: Create backups on-demand through admin panel
- **Automated Backups**: Scheduled daily backups with configurable timing
- **Backup History**: View complete backup history with metadata
- **Retention Policy**: Automatic cleanup of old backups based on configurable retention period

### 🚀 **Restore Capabilities**
- **One-Click Restore**: Easy database restoration from any backup
- **Safety Confirmation**: Multiple confirmation steps before restore
- **Decryption**: Automatic decryption of encrypted backups during restore
- **Rollback Protection**: Confirmation dialogs prevent accidental data loss

### 📁 **File Management**
- **Download Backups**: Download backup files to local storage
- **Backup Metadata**: Track backup size, creation date, and description
- **File Organization**: Automatic file naming and organization
- **Storage Optimization**: Automatic cleanup of old backup files

## Installation & Setup

### Prerequisites
- Laravel 11+ application
- MySQL or PostgreSQL database
- Admin user account
- Sufficient storage space for backups

### 1. **Install Dependencies**
```bash
composer require symfony/process
```

### 2. **Database Tools Installation**

#### For MySQL:
```bash
# Ubuntu/Debian
sudo apt-get install mysql-client

# CentOS/RHEL
sudo yum install mysql

# macOS
brew install mysql-client
```

#### For PostgreSQL:
```bash
# Ubuntu/Debian
sudo apt-get install postgresql-client

# CentOS/RHEL
sudo yum install postgresql

# macOS
brew install postgresql
```

### 3. **Storage Directory Setup**
```bash
# Create backup storage directory
mkdir -p storage/app/backups

# Set proper permissions
chmod 755 storage/app/backups
```

### 4. **Environment Configuration**
Add these variables to your `.env` file:
```env
# Backup Configuration
SEMS_AUTO_BACKUP_ENABLED=true
SEMS_BACKUP_RETENTION_DAYS=30
SEMS_BACKUP_TIME=02:00
```

## Usage

### **Admin Panel Access**
1. Login as an admin user
2. Navigate to **Backups** in the admin navigation
3. Access the backup management interface

### **Creating Manual Backups**
1. Go to **Database Backup Management**
2. Fill in optional description
3. Choose encryption option (recommended: enabled)
4. Click **Create Backup**
5. Wait for backup completion

### **Downloading Backups**
1. In the backup history table, click the download icon
2. Choose download location on your device
3. File will be automatically decrypted if encrypted

### **Restoring from Backup**
1. **⚠️ WARNING**: This will replace your current database
2. Click the restore icon next to the desired backup
3. Confirm the action in the modal dialog
4. Check the confirmation checkbox
5. Click **Restore**
6. Wait for restoration to complete

### **Managing Backup Files**
- **View Details**: See backup size, creation date, and description
- **Delete Backups**: Remove unnecessary backup files
- **Monitor Storage**: Track total backup storage usage

## Console Commands

### **Manual Backup Creation**
```bash
# Create encrypted backup
php artisan backup:create --encrypt

# Create unencrypted backup
php artisan backup:create

# Create backup with description
php artisan backup:create --description="Before system update"
```

### **Scheduled Backups**
The system automatically creates daily backups at 2:00 AM by default.

To run the scheduler manually:
```bash
# Run scheduled tasks
php artisan schedule:run

# Test backup command
php artisan backup:create --encrypt --description="Test backup"
```

## Configuration

### **Backup Settings** (`config/sems.php`)
```php
// Backup Settings
'auto_backup_enabled' => env('SEMS_AUTO_BACKUP_ENABLED', true),
'backup_retention_days' => env('SEMS_BACKUP_RETENTION_DAYS', 30),
'backup_time' => env('SEMS_BACKUP_TIME', '02:00'),
```

### **Environment Variables**
```env
# Enable/disable automated backups
SEMS_AUTO_BACKUP_ENABLED=true

# Number of days to keep backups
SEMS_BACKUP_RETENTION_DAYS=30

# Time for daily backup (24-hour format)
SEMS_BACKUP_TIME=02:00
```

## File Structure

```
storage/app/backups/
├── backup_2024-01-15_02-00-00.sql.encrypted
├── backup_2024-01-16_02-00-00.sql.encrypted
├── backup_2024-01-17_02-00-00.sql.encrypted
└── metadata.json
```

### **Metadata File Structure**
```json
[
  {
    "filename": "backup_2024-01-17_02-00-00.sql.encrypted",
    "description": "Automated backup",
    "encrypted": true,
    "size": 1048576,
    "created_at": "2024-01-17T02:00:00.000000Z",
    "created_by": "system",
    "type": "automated"
  }
]
```

## Security Considerations

### **Access Control**
- Only admin users can access backup management
- All backup operations require authentication
- Backup files are stored outside web root

### **Encryption**
- Uses Laravel's built-in encryption (AES-256-CBC)
- Encryption key stored in application configuration
- Backups are encrypted before storage

### **File Permissions**
- Backup directory has restricted access (755)
- Backup files are readable only by application
- Metadata file contains sensitive information

## Troubleshooting

### **Common Issues**

#### 1. **Backup Creation Fails**
```bash
# Check database connection
php artisan tinker
DB::connection()->getPdo();

# Verify database tools installation
which mysqldump  # MySQL
which pg_dump     # PostgreSQL
```

#### 2. **Permission Denied Errors**
```bash
# Fix storage permissions
chmod -R 755 storage/app/backups
chown -R www-data:www-data storage/app/backups
```

#### 3. **Insufficient Storage**
```bash
# Check available disk space
df -h

# Clean up old backups manually
php artisan backup:cleanup
```

#### 4. **Restore Fails**
- Verify backup file integrity
- Check database connection
- Ensure sufficient disk space
- Verify user permissions

### **Log Files**
Check Laravel logs for detailed error information:
```bash
tail -f storage/logs/laravel.log
```

## Best Practices

### **Backup Strategy**
1. **Daily Automated Backups**: Keep system running with minimal data loss
2. **Manual Backups Before Updates**: Create backups before major changes
3. **Offsite Storage**: Consider copying backups to external storage
4. **Regular Testing**: Test restore procedures periodically

### **Storage Management**
1. **Monitor Space**: Regularly check backup storage usage
2. **Retention Policy**: Adjust retention period based on needs
3. **Compression**: Consider enabling backup compression for large databases
4. **Cleanup**: Regularly review and remove old backups

### **Security**
1. **Access Control**: Limit backup access to essential personnel
2. **Encryption**: Always enable backup encryption
3. **Audit Logging**: Monitor backup access and operations
4. **Secure Storage**: Store backups in secure, restricted locations

## Monitoring & Maintenance

### **Health Checks**
```bash
# Check backup system status
php artisan backup:status

# Verify scheduled tasks
php artisan schedule:list

# Test backup creation
php artisan backup:create --description="Health check"
```

### **Performance Monitoring**
- Monitor backup creation time
- Track backup file sizes
- Monitor storage usage trends
- Check for failed backup attempts

### **Regular Maintenance**
- Review backup retention policies
- Clean up old backup files
- Verify backup integrity
- Test restore procedures

## Support & Documentation

### **Additional Resources**
- [Laravel Documentation](https://laravel.com/docs)
- [MySQL Backup Documentation](https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html)
- [PostgreSQL Backup Documentation](https://www.postgresql.org/docs/current/app-pgdump.html)

### **System Requirements**
- PHP 8.2+
- Laravel 11+
- MySQL 8.0+ or PostgreSQL 12+
- Sufficient storage space (recommended: 10x database size)

### **Contact Information**
For technical support or questions about the backup system, contact the system administrator or development team.

---

**⚠️ Important**: Always test your backup and restore procedures in a development environment before implementing in production. Database restoration is a critical operation that can result in data loss if not performed correctly.
