<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Email Address - SEMS System</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #b91c1c;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #b91c1c;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .verification-box {
            background-color: #fff1f2;
            padding: 28px;
            border-radius: 10px;
            margin: 24px 0;
            text-align: center;
            border: 1px solid #fee2e2;
        }
        .verification-button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            margin: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }
        .verification-button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }
        .warning-box h4 {
            color: #856404;
            margin-top: 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e($message->embed(public_path('images/ub-logo.png'))); ?>" alt="University of Baguio" style="max-height: 56px; display: block; margin: 0 auto 10px;">
            <h1>Verify Your Email Address</h1>
        </div>
        
        <div class="content">
            <p style="font-size:16px;">Hello <strong><?php echo e($user->name); ?></strong>,</p>
            <p style="font-size:15px;color:#374151;">Thanks for using the Sports Equipment Management System. To keep your account secure, please verify your email address.</p>
            
            <div class="verification-box">
                <h3 style="margin-top: 0; color: #b91c1c;">Email Verification Required</h3>
                <p style="margin-bottom: 20px; color: #6b7280;">Click the button below to verify your email address and activate your account.</p>
                
                <a href="<?php echo e($verificationUrl); ?>" class="verification-button">
                    Verify Email Address
                </a>
                
                <p style="font-size: 12px; color: #6b7280; margin-top: 15px;">
                    If the button doesn't work, copy and paste this link into your browser:<br>
                    <a href="<?php echo e($verificationUrl); ?>" style="color: #3b82f6; word-break: break-all;"><?php echo e($verificationUrl); ?></a>
                </p>
            </div>
            
            <div class="warning-box">
                <h4>Important Security Notice</h4>
                <p style="margin: 0;">This verification link will expire in 60 minutes. If you did not request this email verification, please ignore this message and contact the system administrator if you have concerns.</p>
            </div>
            
            <p><strong>What happens next?</strong></p>
            <ul>
                <li>Click the verification button above</li>
                <li>You'll be redirected to the SEMS system</li>
                <li>Your email address will be verified and activated</li>
                <li>You can continue using all system features</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>This is an automated message from the SEMS System.</p>
            <p>If you have any questions, please contact the system administrator.</p>
            <p><small>Please do not reply to this email.</small></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\emails\verify-email.blade.php ENDPATH**/ ?>