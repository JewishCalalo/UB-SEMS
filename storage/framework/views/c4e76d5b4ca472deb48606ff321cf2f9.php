<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservation Status Updated - SEMS System</title>
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
        .status-approved {
            background-color: #d4edda;
            color: #155724;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .status-denied {
            background-color: #f8d7da;
            color: #721c24;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .status-picked-up {
            background-color: #cce5ff;
            color: #004085;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .status-returned {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
        }
        .remarks {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e($message->embed(public_path('images/ub-logo.png'))); ?>" alt="SEMS Logo" style="max-height: 50px; display: block; margin: 0 auto 10px;">
            <h1>Reservation Status Updated</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong><?php echo e($recipientName); ?></strong>,</p>
            
            <p>Your equipment reservation status has been updated in the SEMS (Sports Equipment Management System).</p>
            
            <div class="reservation-details">
                <h3>Reservation Details:</h3>
                <p><strong>Reservation Code:</strong></p>
                <div class="reservation-code"><?php echo e($reservation->reservation_code); ?></div>
                
                <p><strong>New Status:</strong> 
                    <?php if($status === 'approved'): ?>
                        <span class="status-approved">Approved</span>
                    <?php elseif($status === 'denied'): ?>
                        <span class="status-denied">Denied</span>
                    <?php elseif($status === 'picked_up'): ?>
                        <span class="status-picked-up">Picked Up</span>
                    <?php elseif($status === 'returned'): ?>
                        <span class="status-returned">Returned</span>
                    <?php elseif($status === 'completed'): ?>
                        <span class="status-completed">Completed</span>
                    <?php else: ?>
                        <span class="status-pending"><?php echo e(ucfirst(str_replace('_', ' ', $status))); ?></span>
                    <?php endif; ?>
                </p>
                
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
                <?php if($reservation->pickup_date): ?>
                    <p><strong>Pickup Date:</strong> <?php echo e(\Carbon\Carbon::parse($reservation->pickup_date)->format('F j, Y')); ?></p>
                <?php endif; ?>
                <p><strong>Department:</strong> <?php echo e($reservation->department ?? 'Not specified'); ?></p>
                <p><strong>Reason:</strong> <?php echo e($reservation->reason); ?></p>
                
                <?php if($reservation->additional_details): ?>
                    <p><strong>Additional Details:</strong> <?php echo e($reservation->additional_details); ?></p>
                <?php endif; ?>
            </div>
            
            <h3>Equipment Summary:</h3>
            <ul>
                <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $brandModel = trim(($item->equipment->brand ?? '') . ' ' . ($item->equipment->model ?? ''));
                    ?>
                    <li>
                        <strong><?php echo e($item->equipment->name ?? ($brandModel ?: 'Equipment')); ?></strong>
                        <?php if(!empty($item->equipment->name) && $brandModel): ?>
                            (<?php echo e($brandModel); ?>)
                        <?php elseif(empty($item->equipment->name) && $brandModel): ?>
                            <?php echo e($brandModel); ?>

                        <?php endif; ?>
                        — Quantity: 
                        <?php if(!is_null($item->quantity_approved) && $item->quantity_approved > 0): ?>
                            <?php echo e($item->quantity_approved); ?> (Approved)
                        <?php else: ?>
                            <?php echo e($item->quantity_requested); ?> (Requested)
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            
            <?php if($remarks): ?>
                <div class="remarks">
                    <h4>Remarks from Staff:</h4>
                    <p><?php echo e($remarks); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if($status === 'approved'): ?>
                <p><strong>Congratulations!</strong> Your reservation has been approved. You can now pick up your equipment on the specified pickup date.</p>
                <?php if($reservation->pickup_date): ?>
                    <p><strong>Pickup Date:</strong> <?php echo e(\Carbon\Carbon::parse($reservation->pickup_date)->format('F j, Y')); ?></p>
                <?php endif; ?>
                <p><strong>Important Notes:</strong></p>
                <ul>
                    <li>Pickup date is set between your requested borrow and return dates</li>
                    <li>Your equipment must be returned by the specified return date to avoid being marked as overdue</li>
                    <li>Please return all equipment by the specified return date to avoid penalties</li>
                </ul>
            <?php elseif($status === 'denied'): ?>
                <p><strong>Notice:</strong> Your reservation has been denied. Please contact the staff for more information or submit a new reservation.</p>
            <?php elseif($status === 'picked_up'): ?>
                <p><strong>Equipment Picked Up:</strong> Your equipment has been successfully picked up. Please return it by the specified return date.</p>
                
                <h3>Equipment Items & Pickup Details:</h3>
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 15px 0;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="background-color: #e9ecef;">
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Instance Code</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Category & Type</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Current Condition</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Pickup Condition</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $item->reservationItemInstances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservationItemInstance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $instance = $reservationItemInstance->equipmentInstance;
                                    ?>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;"><?php echo e($instance->instance_code ?: 'Instance #' . $instance->id); ?></td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <div style="font-weight: bold;"><?php echo e($item->equipment->category->name ?? 'N/A'); ?></div>
                                            <div style="color: #6c757d; font-size: 12px;"><?php echo e($item->equipment->equipmentType->name ?? 'No type specified'); ?></div>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <span style="background-color: #cce5ff; color: #004085; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                <?php echo e(ucfirst($instance->condition)); ?>

                                            </span>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->pickup_condition): ?>
                                                <span style="background-color: #d4edda; color: #155724; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $reservationItemInstance->pickup_condition))); ?>

                                                </span>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">Not recorded</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->pickup_notes): ?>
                                                <div style="font-size: 12px; color: #495057;"><?php echo e($reservationItemInstance->pickup_notes); ?></div>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">No notes</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif($status === 'returned'): ?>
                <p><strong>Equipment Returned:</strong> Thank you for returning the equipment on time!</p>
                
                <h3>Equipment Items & Return Details:</h3>
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 15px 0;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="background-color: #e9ecef;">
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Instance Code</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Category & Type</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Previous Condition</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Return Condition</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $item->reservationItemInstances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservationItemInstance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $instance = $reservationItemInstance->equipmentInstance;
                                    ?>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;"><?php echo e($instance->instance_code ?: 'Instance #' . $instance->id); ?></td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <div style="font-weight: bold;"><?php echo e($item->equipment->category->name ?? 'N/A'); ?></div>
                                            <div style="color: #6c757d; font-size: 12px;"><?php echo e($item->equipment->equipmentType->name ?? 'No type specified'); ?></div>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->pickup_condition): ?>
                                                <span style="background-color: #cce5ff; color: #004085; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $reservationItemInstance->pickup_condition))); ?>

                                                </span>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">Not recorded</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->returned_condition): ?>
                                                <span style="background-color: #d1ecf1; color: #0c5460; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $reservationItemInstance->returned_condition))); ?>

                                                </span>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">Not recorded</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->returned_notes): ?>
                                                <div style="font-size: 12px; color: #495057;"><?php echo e($reservationItemInstance->returned_notes); ?></div>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">No notes</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php
                    $lostItems = [];
                    foreach($reservation->items as $item){
                        foreach($item->reservationItemInstances as $rii){
                            if(($rii->returned_condition ?? null) === 'lost'){
                                $inst = $rii->equipmentInstance;
                                $lostItems[] = [
                                    'code' => $inst->instance_code ?: ('Instance #' . $inst->id),
                                    'equipment' => $item->equipment->name ?? ($item->equipment->display_name ?? 'Equipment'),
                                    'category' => optional($item->equipment->category)->name,
                                ];
                            }
                        }
                    }
                ?>
                <?php if(!empty($lostItems)): ?>
                    <div style="background-color:#fff3cd;border:1px solid #ffeaa7;padding:15px;border-radius:6px;margin:15px 0;">
                        <h4 style="margin:0 0 10px 0;">Action Required: Lost Equipment</h4>
                        <p style="margin:0 0 10px 0;">The following items were marked as <strong>Lost</strong> during return processing. Please coordinate with the department to replace these items as per policy.</p>
                        <ul style="margin:0;padding-left:18px;">
                            <?php $__currentLoopData = $lostItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $li): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><strong><?php echo e($li['code']); ?></strong> — <?php echo e($li['equipment']); ?> <?php if($li['category']): ?> (<?php echo e($li['category']); ?>) <?php endif; ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php elseif($status === 'completed'): ?>
                <p><strong>Reservation Completed:</strong> Your reservation has been successfully completed.</p>

                <h3>Final Equipment Conditions:</h3>
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 15px 0;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="background-color: #e9ecef;">
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Instance Code</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Category & Type</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Pickup Condition</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Final Condition</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6; font-weight: bold;">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $item->reservationItemInstances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservationItemInstance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $instance = $reservationItemInstance->equipmentInstance;
                                    ?>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;"><?php echo e($instance->instance_code ?: 'Instance #' . $instance->id); ?></td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <div style="font-weight: bold;"><?php echo e($item->equipment->category->name ?? 'N/A'); ?></div>
                                            <div style="color: #6c757d; font-size: 12px;"><?php echo e($item->equipment->equipmentType->name ?? 'No type specified'); ?></div>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->pickup_condition): ?>
                                                <span style="background-color: #cce5ff; color: #004085; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $reservationItemInstance->pickup_condition))); ?>

                                                </span>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">Not recorded</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->returned_condition): ?>
                                                <span style="background-color: #d1ecf1; color: #0c5460; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $reservationItemInstance->returned_condition))); ?>

                                                </span>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">Not recorded</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 8px; border: 1px solid #dee2e6;">
                                            <?php if($reservationItemInstance->returned_notes): ?>
                                                <div style="font-size: 12px; color: #495057;"><?php echo e($reservationItemInstance->returned_notes); ?></div>
                                            <?php else: ?>
                                                <span style="color: #6c757d;">No notes</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php
                    $lostItemsCompleted = [];
                    foreach($reservation->items as $item){
                        foreach($item->reservationItemInstances as $rii){
                            if(($rii->returned_condition ?? null) === 'lost'){
                                $inst = $rii->equipmentInstance;
                                $lostItemsCompleted[] = [
                                    'code' => $inst->instance_code ?: ('Instance #' . $inst->id),
                                    'equipment' => $item->equipment->name ?? ($item->equipment->display_name ?? 'Equipment'),
                                    'category' => optional($item->equipment->category)->name,
                                ];
                            }
                        }
                    }
                ?>
                <?php if(!empty($lostItemsCompleted)): ?>
                    <div style="background-color:#fff3cd;border:1px solid #ffeaa7;padding:15px;border-radius:6px;margin:15px 0;">
                        <h4 style="margin:0 0 10px 0;">Action Required: Lost Equipment</h4>
                        <p style="margin:0 0 10px 0;">The following items were marked as <strong>Lost</strong>. Please arrange replacement with your department as per policy.</p>
                        <ul style="margin:0;padding-left:18px;">
                            <?php $__currentLoopData = $lostItemsCompleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $li): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><strong><?php echo e($li['code']); ?></strong> — <?php echo e($li['equipment']); ?> <?php if($li['category']): ?> (<?php echo e($li['category']); ?>) <?php endif; ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>Thank you for using SEMS!</p>
            <p>If you have any questions, please contact the system administrator.</p>
            <p><small>This is an automated message. Please do not reply to this email.</small></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\emails\reservation-status-updated.blade.php ENDPATH**/ ?>