# Email Setup Guide for SEMS

## Gmail SMTP Configuration

### Step 1: Enable 2-Factor Authentication
1. Go to your Google Account settings: https://myaccount.google.com/
2. Navigate to "Security"
3. Enable "2-Step Verification" if not already enabled

### Step 2: Generate App Password
1. Go to Google Account settings: https://myaccount.google.com/
2. Navigate to "Security" → "2-Step Verification"
3. Scroll down and click "App passwords"
4. Select "Mail" as the app and "Other" as the device
5. Click "Generate"
6. Copy the 16-character password (e.g., `abcd efgh ijkl mnop`)

### Step 3: Update .env File
Update your `.env` file with the new app password:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=vawdrac@gmail.com
MAIL_PASSWORD=your_16_character_app_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=vawdrac@gmail.com
MAIL_FROM_NAME="SEMS - University of Baguio"
```

### Step 4: Test Email Configuration
Run the test command:
```bash
php artisan test:email your-email@example.com
```

## Alternative Email Providers

### Option 2: Use Mailtrap (Development/Testing)
For development, you can use Mailtrap:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

### Option 3: Use University Email Server
If you have access to the university's email server:

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.ubaguio.edu
MAIL_PORT=587
MAIL_USERNAME=your_ubaguio_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

## Troubleshooting

### Common Issues:
1. **Authentication Failed**: Use App Password instead of regular password
2. **Connection Timeout**: Check firewall settings
3. **Port Blocked**: Try port 465 with SSL instead of 587 with TLS

### Test Commands:
```bash
# Test email configuration
php artisan test:email test@example.com

# Clear configuration cache
php artisan config:clear

# Check mail configuration
php artisan config:show mail
```

## Security Notes:
- Never commit your `.env` file to version control
- Use App Passwords for Gmail instead of regular passwords
- Consider using environment-specific email configurations
- Regularly rotate app passwords
