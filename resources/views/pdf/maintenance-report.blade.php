<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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
        <h1>{{ $title }}</h1>
        <p>University of Baguio - Physical Education Office</p>
        <p>Generated on: {{ $generated_at }}</p>
    </div>

    @if(!empty($filters))
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if(isset($filters['report_type']) && $filters['report_type'])
            <p><strong>Report Type:</strong> {{ ucfirst($filters['report_type']) }}</p>
        @endif
        @if(isset($filters['category_name']) && $filters['category_name'])
            <p><strong>Category:</strong> {{ $filters['category_name'] }}</p>
        @elseif(isset($filters['category']) && $filters['category'])
            @php $cn = optional(\App\Models\EquipmentCategory::find($filters['category']))->name; @endphp
            <p><strong>Category:</strong> {{ $cn ?: $filters['category'] }}</p>
        @endif
        @if(isset($filters['equipment_type_name']) && $filters['equipment_type_name'])
            <p><strong>Equipment Type:</strong> {{ $filters['equipment_type_name'] }}</p>
        @elseif(isset($filters['equipment_type']) && $filters['equipment_type'])
            @php $tn = optional(\App\Models\EquipmentType::find($filters['equipment_type']))->name; @endphp
            <p><strong>Equipment Type:</strong> {{ $tn ?: $filters['equipment_type'] }}</p>
        @endif
        @if(isset($filters['start_date']) && $filters['start_date'])
            <p><strong>Start Date:</strong> {{ $filters['start_date'] }}</p>
        @endif
        @if(isset($filters['end_date']) && $filters['end_date'])
            <p><strong>End Date:</strong> {{ $filters['end_date'] }}</p>
        @endif
    </div>
    @endif

    

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
            @foreach($equipmentInstances as $instance)
            <tr>
                <td>{{ $instance->instance_code }}</td>
                <td>{{ $instance->equipment->model ?? 'N/A' }}</td>
                <td>{{ $instance->equipment->category->name }}</td>
                <td>{{ $instance->equipment->equipmentType->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($instance->condition) }}</td>
                <td>
                    @php
                        $lastMaintenance = $instance->maintenanceRecords->sortByDesc('maintenance_date')->first();
                    @endphp
                    @if($lastMaintenance && $lastMaintenance->maintenance_date)
                        @if($lastMaintenance->maintenance_date instanceof \Carbon\Carbon)
                            {{ $lastMaintenance->maintenance_date->format('M d, Y') }}
                        @else
                            {{ \Carbon\Carbon::parse($lastMaintenance->maintenance_date)->format('M d, Y') }}
                        @endif
                    @else
                        No maintenance
                    @endif
                </td>
                <td>
                    {{ $lastMaintenance ? ucfirst($lastMaintenance->maintenance_type) : 'N/A' }}
                </td>
                <td>
                    {{ $lastMaintenance ? $lastMaintenance->performed_by : 'N/A' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Equipment Instances: {{ $equipmentInstances->count() }}</p>
        <p>This report was generated automatically by the SEMS system.</p>
    </div>
</body>
</html>
