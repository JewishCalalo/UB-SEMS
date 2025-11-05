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
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .reason-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .reason-beyond-repair { background-color: #fee2e2; color: #dc2626; }
        .reason-lost { background-color: #fef3c7; color: #d97706; }
        .reason-stolen { background-color: #f3e8ff; color: #9333ea; }
        .reason-end-of-life { background-color: #e5e7eb; color: #374151; }
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
        <?php if(isset($filters['report_type']) && $filters['report_type']): ?>
            <p><strong>Report Type:</strong> <?php echo e($filters['report_type']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['category']) && $filters['category']): ?>
            <?php $cn = optional(\App\Models\EquipmentCategory::find($filters['category']))->name; ?>
            <p><strong>Category:</strong> <?php echo e($cn ?: $filters['category']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['equipment_type']) && $filters['equipment_type']): ?>
            <?php $tn = optional(\App\Models\EquipmentType::find($filters['equipment_type']))->name; ?>
            <p><strong>Equipment Type:</strong> <?php echo e($tn ?: $filters['equipment_type']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['equipment']) && $filters['equipment']): ?>
            <p><strong>Equipment:</strong> <?php echo e($filters['equipment']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['start_date']) && $filters['start_date']): ?>
            <p><strong>Start Date:</strong> <?php echo e($filters['start_date']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['end_date']) && $filters['end_date']): ?>
            <p><strong>End Date:</strong> <?php echo e($filters['end_date']); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Brand/Model</th>
                <th>Instance Code</th>
                <th>Category</th>
                <th>Reason</th>
                <th>Discarded By</th>
                <th>Date Discarded</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $discardedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <strong><?php echo e($item->equipmentInstance->equipment->brand ?: 'No brand'); ?></strong><br>
                    <small><?php echo e($item->equipmentInstance->equipment->model ?: 'No model'); ?></small>
                </td>
                <td><?php echo e($item->equipmentInstance->instance_code); ?></td>
                <td><?php echo e($item->equipmentInstance->equipment->category->name); ?></td>
                <td>
                    <span class="reason-badge reason-<?php echo e($item->reason); ?>">
                        <?php echo e(ucwords(str_replace('_', ' ', $item->reason))); ?>

                    </span>
                </td>
                <td><?php echo e($item->actedBy ? $item->actedBy->name : 'System'); ?></td>
                <td><?php echo e($item->acted_at ? $item->acted_at->format('M d, Y H:i') : 'N/A'); ?></td>
                <td><?php echo e(Str::limit($item->notes ?: 'No notes', 30)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Total Discarded Items: <?php echo e($discardedItems->count()); ?></p>
        <p>This report was generated automatically by the SEMS system.</p>
    </div>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\pdf\discarded-report.blade.php ENDPATH**/ ?>