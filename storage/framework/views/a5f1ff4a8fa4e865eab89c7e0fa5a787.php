<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEMS Verification Code</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background:#f7fafc; margin:0; padding:20px; color:#111827; }
        .wrap { max-width:600px; margin:0 auto; background:#ffffff; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,.08); overflow:hidden; }
        .header { text-align:center; padding:20px 24px; border-bottom:1px solid #f1f5f9; }
        .brand { max-height:56px; display:block; margin:0 auto 8px; }
        .title { margin:0; font-size:20px; color:#b91c1c; }
        .content { padding:24px; font-size:15px; line-height:1.6; color:#374151; }
        .code-box { background:#fff1f2; border:1px solid #fee2e2; border-radius:10px; padding:24px; text-align:center; margin:18px 0; }
        .code { font-family: 'SFMono-Regular', Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; font-size:36px; letter-spacing:6px; font-weight:800; color:#111827; display:inline-block; padding:8px 12px; }
        .note { font-size:13px; color:#6b7280; margin-top:8px; }
        .footer { text-align:center; padding:16px 24px 22px; border-top:1px solid #f1f5f9; font-size:12px; color:#6b7280; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <img class="brand" src="<?php echo e($message->embed(public_path('images/ub-logo.png'))); ?>" alt="University of Baguio">
            <h1 class="title">Your Verification Code</h1>
        </div>

        <div class="content">
            <p>Hello<?php echo e(isset($name) && $name ? ' ' . $name : ''); ?>,</p>
            <p>Use the verification code below to continue your reservation in the Sports Equipment Management System (SEMS).</p>

            <div class="code-box">
                <div class="code"><?php echo e($code); ?></div>
                <div class="note">This code will expire in <?php echo e($expiresIn ?? 15); ?> minutes.</div>
            </div>

            <p>If you didn’t request this code, you can safely ignore this email.</p>
        </div>

        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> University of Baguio • SEMS. Please do not reply to this email.
        </div>
    </div>
</body>
</html>


<?php /**PATH C:\UB-SEMS\resources\views\emails\guest-otp.blade.php ENDPATH**/ ?>