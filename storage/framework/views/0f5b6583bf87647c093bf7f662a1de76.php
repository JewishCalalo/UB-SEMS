<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header img {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        .filters p {
            margin: 2px 0;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status-pending { background-color: #fff3cd; }
        .status-approved { background-color: #d4edda; }
        .status-denied { background-color: #f8d7da; }
        .status-picked_up { background-color: #cce5ff; }
        .status-returned { background-color: #e2e3e5; }
        .status-completed { background-color: #d1ecf1; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e($title); ?></h1>
        <p>University of Baguio - Physical Education Office</p>
        <p>Generated on: <?php echo e($generated_at); ?></p>
    </div>

    <?php if(!empty($filters)): ?>
    <div class="filters">
        <h3>Applied Filters:</h3>
        <?php if(isset($filters['status']) && $filters['status']): ?>
            <p><strong>Status:</strong> <?php echo e(ucfirst($filters['status'])); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['report_type']) && $filters['report_type']): ?>
            <p><strong>Report Type:</strong> <?php echo e(ucfirst($filters['report_type'])); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['user']) && $filters['user']): ?>
            <p><strong>User:</strong> <?php echo e($filters['user']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['equipment']) && $filters['equipment']): ?>
            <p><strong>Equipment:</strong> <?php echo e($filters['equipment']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['category']) && $filters['category']): ?>
            <?php
                $category = \App\Models\EquipmentCategory::find($filters['category']);
                $categoryName = $category ? $category->name : 'Unknown';
            ?>
            <p><strong>Category:</strong> <?php echo e($categoryName); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['equipment_type']) && $filters['equipment_type']): ?>
            <?php
                $equipmentType = \App\Models\EquipmentType::find($filters['equipment_type']);
                $equipmentTypeName = $equipmentType ? $equipmentType->name : 'Unknown';
            ?>
            <p><strong>Equipment Type:</strong> <?php echo e($equipmentTypeName); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['date_from']) && $filters['date_from']): ?>
            <p><strong>Date From:</strong> <?php echo e($filters['date_from']); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>User</th>
                <th>Email</th>
                <th>Equipment</th>
                <th>Status</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Reason</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($reservation->reservation_code); ?></td>
                    <td><?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?></td>
                    <td><?php echo e($reservation->user ? $reservation->user->email : ($reservation->email ?? 'No email')); ?></td>
                    <td><?php echo e($item->equipment->name); ?> (<?php echo e($item->quantity_requested); ?>x)</td>
                    <td class="status-<?php echo e($reservation->status); ?>"><?php echo e(ucfirst($reservation->status)); ?></td>
                    <td><?php echo e($reservation->borrow_date->format('M d, Y')); ?></td>
                    <td><?php echo e($reservation->return_date->format('M d, Y')); ?></td>
                    <td><?php echo e(Str::limit($reservation->reason, 30)); ?></td>
                    <td><?php echo e($reservation->created_at->format('M d, Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Total Records: <?php echo e($reservations->count()); ?></p>
        <p>This report was generated automatically by the SEMS system.</p>
    </div>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\pdf\reservation-report.blade.php ENDPATH**/ ?>