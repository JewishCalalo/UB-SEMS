# Render Deployment Guide for SEMS

## Email Configuration on Render

**CRITICAL**: By default, Laravel uses the `log` mail driver, which writes emails to log files instead of sending them. This means verification codes and reservation updates **will not be sent** unless you configure a real email provider.

### Option 1: Use Resend (Recommended for Production)

Resend is already included in your `composer.json`. It's reliable and has a generous free tier.

1. **Sign up for Resend**: https://resend.com/
2. **Create an API Key**: Go to API Keys → Create API Key
3. **Set Environment Variables in Render**:
   - Go to your Render service → Environment
   - Add these variables:
     ```
     MAIL_MAILER=resend
     RESEND_API_KEY=your_api_key_here
     MAIL_FROM_ADDRESS=noreply@sems.ubaguio.edu
     MAIL_FROM_NAME="SEMS - University of Baguio"
     ```

### Option 2: Use Gmail SMTP (Free, but requires App Password)

1. **Enable 2-Factor Authentication** on your Gmail account
2. **Generate App Password**: https://myaccount.google.com/apppasswords
3. **Set Environment Variables in Render**:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_gmail@gmail.com
   MAIL_PASSWORD=your_16_character_app_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_gmail@gmail.com
   MAIL_FROM_NAME="SEMS - University of Baguio"
   ```

### Option 3: Use SendGrid (Free Tier Available)

1. **Sign up for SendGrid**: https://sendgrid.com/
2. **Create API Key**
3. **Set Environment Variables in Render**:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.sendgrid.net
   MAIL_PORT=587
   MAIL_USERNAME=apikey
   MAIL_PASSWORD=your_sendgrid_api_key
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@sems.ubaguio.edu
   MAIL_FROM_NAME="SEMS - University of Baguio"
   ```

### After Setting Environment Variables

1. **Redeploy your service** on Render (or restart it)
2. **Clear config cache** (if needed):
   ```bash
   php artisan config:clear
   ```
3. **Test email sending**:
   - Try making a reservation
   - Check your email inbox for the verification code
   - Check Render logs: `storage/logs/laravel.log` if emails fail

### Troubleshooting

**Emails not sending?**
- Check Render logs for email errors
- Verify environment variables are set correctly
- Ensure `MAIL_MAILER` is NOT set to `log`
- Test with: `php artisan tinker` → `Mail::raw('Test', function($m) { $m->to('your@email.com')->subject('Test'); });`

**Form submission not working?**
- Check browser console for JavaScript errors
- Verify CSRF token is present in `<head>` (should be auto-included)
- Check Render logs for server errors

**Verification code not received?**
- Most likely: Email is set to `log` driver (check `.env` or Render environment variables)
- Check `storage/logs/laravel.log` - emails will be logged there if using `log` driver
- Verify email address format: must be `@s.ubaguio.edu` or `@e.ubaguio.edu`

## Other Render Configuration

### Database
- Use PostgreSQL (recommended) or MySQL
- Set `DB_CONNECTION` in environment variables
- Run migrations: `php artisan migrate`

### Queue Worker (Optional)
If you use queues for email:
- Create a Background Worker service
- Command: `php artisan queue:work`
- Link to same database as web service

### Scheduled Tasks
Render doesn't support cron directly. Use:
- External cron service (e.g., cron-job.org)
- Or Render Cron Jobs (if available in your plan)


