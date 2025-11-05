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
            font-size: 14px; color: #333;
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
            <p><strong>Report Type:</strong> <?php echo e(ucfirst($filters['report_type'])); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['category_name']) && $filters['category_name']): ?>
            <p><strong>Category:</strong> <?php echo e($filters['category_name']); ?></p>
        <?php elseif(isset($filters['category']) && $filters['category']): ?>
            <?php $cn = optional(\App\Models\EquipmentCategory::find($filters['category']))->name; ?>
            <p><strong>Category:</strong> <?php echo e($cn ?: $filters['category']); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['equipment_type_name']) && $filters['equipment_type_name']): ?>
            <p><strong>Equipment Type:</strong> <?php echo e($filters['equipment_type_name']); ?></p>
        <?php elseif(isset($filters['equipment_type']) && $filters['equipment_type']): ?>
            <?php $tn = optional(\App\Models\EquipmentType::find($filters['equipment_type']))->name; ?>
            <p><strong>Equipment Type:</strong> <?php echo e($tn ?: $filters['equipment_type']); ?></p>
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
                <th>Instance Code</th>
                <th>Model</th>
                <th>Category</th>
                <th>Equipment Type</th>
                <th>Instance Condition</th>
                <th>Last Maintenance Date</th>
                <th>Maintenance Type</th>
                <th>Performed By</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $equipmentInstances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($instance->instance_code); ?></td>
                <td><?php echo e($instance->equipment->model ?? 'N/A'); ?></td>
                <td><?php echo e($instance->equipment->category->name); ?></td>
                <td><?php echo e($instance->equipment->equipmentType->name ?? 'N/A'); ?></td>
                <td><?php echo e(ucfirst($instance->condition)); ?></td>
                <td>
                    <?php
                        $lastMaintenance = $instance->maintenanceRecords->sortByDesc('maintenance_date')->first();
                    ?>
                    <?php if($lastMaintenance && $lastMaintenance->maintenance_date): ?>
                        <?php if($lastMaintenance->maintenance_date instanceof \Carbon\Carbon): ?>
                            <?php echo e($lastMaintenance->maintenance_date->format('M d, Y')); ?>

                        <?php else: ?>
                            <?php echo e(\Carbon\Carbon::parse($lastMaintenance->maintenance_date)->format('M d, Y')); ?>

                        <?php endif; ?>
                    <?php else: ?>
                        No maintenance
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e($lastMaintenance ? ucfirst($lastMaintenance->maintenance_type) : 'N/A'); ?>

                </td>
                <td>
                    <?php echo e($lastMaintenance ? $lastMaintenance->performed_by : 'N/A'); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Total Equipment Instances: <?php echo e($equipmentInstances->count()); ?></p>
        <p>This report was generated automatically by the SEMS system.</p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/pdf/maintenance-report.blade.php ENDPATH**/ ?>