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
        <?php if(isset($filters['category']) && $filters['category']): ?>
            <?php
                $category = \App\Models\EquipmentCategory::find($filters['category']);
                $categoryName = $category ? $category->name : 'Unknown';
            ?>
            <p><strong>Category:</strong> <?php echo e($categoryName); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['report_type']) && $filters['report_type']): ?>
            <p><strong>Report Type:</strong> <?php echo e(ucfirst($filters['report_type'])); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['equipment_type']) && $filters['equipment_type']): ?>
            <?php
                $equipmentType = \App\Models\EquipmentType::find($filters['equipment_type']);
                $equipmentTypeName = $equipmentType ? $equipmentType->name : 'Unknown';
            ?>
            <p><strong>Equipment Type:</strong> <?php echo e($equipmentTypeName); ?></p>
        <?php endif; ?>
        <?php if(isset($filters['search']) && $filters['search']): ?>
            <p><strong>Search:</strong> <?php echo e($filters['search']); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Model</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Type</th>
                <th>Condition</th>
                <th>Quantity</th>
                <th>Available</th>
                <th>Location</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->model ?? 'N/A'); ?></td>
                <td><?php echo e($item->brand ?? 'N/A'); ?></td>
                <td><?php echo e($item->category ? $item->category->name : 'N/A'); ?></td>
                <td><?php echo e($item->equipmentType ? $item->equipmentType->name : 'N/A'); ?></td>
                <td><?php echo e($item->quantity_available > 0 ? 'Available' : 'Unavailable'); ?></td>
                <td><?php echo e($item->quantity_total); ?></td>
                <td><?php echo e($item->quantity_available); ?></td>
                <td><?php echo e($item->location ?? 'N/A'); ?></td>
                <td><?php echo e($item->updated_at->format('M d, Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Total Equipment: <?php echo e($equipment->count()); ?></p>
        <p>This report was generated automatically by the SEMS system.</p>
    </div>
</body>
</html>
<?php /**PATH C:\SEMSv26\resources\views/pdf/equipment-report.blade.php ENDPATH**/ ?>