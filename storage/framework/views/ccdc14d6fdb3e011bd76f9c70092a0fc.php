<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservation Created - SEMS System</title>
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
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .reservation-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .reservation-code {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e($message->embed(public_path('images/ub-logo.png'))); ?>" alt="SEMS Logo" style="max-height: 50px; display: block; margin: 0 auto 10px;">
            <h1>Reservation Created Successfully</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong><?php echo e($recipientName); ?></strong>,</p>
            
            <p>Your equipment reservation has been successfully created in the SEMS (Sports Equipment Management System).</p>
            
            <div class="reservation-details">
                <h3>Reservation Details:</h3>
                <p><strong>Reservation Code:</strong></p>
                <div class="reservation-code"><?php echo e($reservation->reservation_code); ?></div>
                
                <p><strong>Status:</strong> <span class="status-pending">Pending Approval</span></p>
                <p><strong>Borrow Date:</strong> <?php echo e(\Carbon\Carbon::parse($reservation->borrow_date)->format('F j, Y')); ?>

                    <?php if($reservation->borrow_time): ?>
                        at <?php echo e(\Carbon\Carbon::parse($reservation->borrow_time)->format('g:i A')); ?>

                    <?php endif; ?>
                </p>
                <p><strong>Return Date:</strong> <?php echo e(\Carbon\Carbon::parse($reservation->return_date)->format('F j, Y')); ?>

                    <?php if($reservation->return_time): ?>
                        at <?php echo e(\Carbon\Carbon::parse($reservation->return_time)->format('g:i A')); ?>

                    <?php endif; ?>
                </p>
                <p><strong>Department:</strong> <?php echo e($reservation->department ?? 'Not specified'); ?></p>
                <p><strong>Reason:</strong> <?php echo e($reservation->reason); ?></p>
                
                <?php if($reservation->additional_details): ?>
                    <p><strong>Additional Details:</strong> <?php echo e($reservation->additional_details); ?></p>
                <?php endif; ?>
            </div>
            
            <h3>Equipment Requested:</h3>
            <ul>
                <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $brandModel = trim(($item->equipment->brand ?? '') . ' ' . ($item->equipment->model ?? ''));
                    ?>
                    <li>
                        <strong><?php echo e($brandModel ?: ($item->equipment->name ?? 'Equipment')); ?></strong>
                        <?php if($item->equipment->name && $brandModel): ?>
                            – <?php echo e($item->equipment->name); ?>

                        <?php endif; ?>
                        — Quantity: <?php echo e($item->quantity_requested); ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            
            <p><strong>Important:</strong> Please save your reservation code <strong><?php echo e($reservation->reservation_code); ?></strong> for future reference and tracking.</p>
            
            <p>Your reservation is currently pending approval. You will receive another email once a manager or admin reviews your request.</p>

            <!-- Removed change-request paragraph: admins/managers cannot modify submitted reservations -->
        </div>
        
        <div class="footer">
            <p>Thank you for using SEMS!</p>
            <p>If you have any questions, please contact the system administrator sample@t.ubaguio.edu.</p>
            <p><small>This is an automated message. Please do not reply to this email.</small></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/emails/reservation-created.blade.php ENDPATH**/ ?>