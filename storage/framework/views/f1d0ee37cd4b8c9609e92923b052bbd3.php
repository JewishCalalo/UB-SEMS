<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Missing Equipment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #dc2626;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        .table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            font-size: 11px;
        }
        .table tr:nth-child(even) {
            background: #f9fafb;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-stolen {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .status-lost {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fed7aa;
        }
        .status-pending {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .status-replaced {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        .status-not-replaced {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
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
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Missing Equipment Report</h1>
        <p>University of Baguio - Physical Education Office</p>
        <p>Generated on: <?php echo e(now()->format('F d, Y \a\t g:i A')); ?></p>
    </div>

    <?php if(!empty($filters)): ?>
    <div class="filters">
        <h3>Applied Filters:</h3>
        <?php if(isset($filters['incident_type']) && $filters['incident_type']): ?>
            <p><strong>Incident Type:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $filters['incident_type']))); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['replacement_status']) && $filters['replacement_status']): ?>
            <p><strong>Replacement Status:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $filters['replacement_status']))); ?></p>
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
            <p><strong>From Date:</strong> <?php echo e($filters['date_from']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['date_to']) && $filters['date_to']): ?>
            <p><strong>To Date:</strong> <?php echo e($filters['date_to']); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if($stolenLostItems->count() > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Equipment</th>
                    <th>Category</th>
                    <th>Borrower</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $stolenLostItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->incident_date ? $item->incident_date->format('M d, Y') : 'N/A'); ?></td>
                        <td>
                            <?php if($item->equipmentInstance && $item->equipmentInstance->equipment): ?>
                                <strong><?php echo e($item->equipmentInstance->equipment->display_name); ?></strong><br>
                                <small><?php echo e($item->equipmentInstance->instance_code); ?></small>
                            <?php else: ?>
                                Equipment not found
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->equipmentInstance && $item->equipmentInstance->equipment && $item->equipmentInstance->equipment->category ? $item->equipmentInstance->equipment->category->name : 'N/A'); ?></td>
                        <td>
                            <strong><?php echo e($item->borrower_name); ?></strong><br>
                            <small><?php echo e($item->borrower_email); ?></small>
                            <?php if($item->borrower_department): ?>
                                <br><small><?php echo e($item->borrower_department); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo e($item->incident_type); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $item->incident_type))); ?>

                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo e($item->replacement_status); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $item->replacement_status))); ?>

                            </span>
                        </td>
                        <td>
                            <?php echo e($item->incident_description ?: 'No description provided'); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #6b7280;">
            <h3>No Records Found</h3>
            <p>There are no missing equipment records to display.</p>
        </div>
    <?php endif; ?>

    <div class="footer">
        <p>This report was automatically generated by the SEMS (Student Equipment Management System)</p>
        <p>For questions or concerns, please contact the Physical Education Office</p>
    </div>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\pdf\missing-equipment.blade.php ENDPATH**/ ?>