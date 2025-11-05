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
        <h1>{{ $title }}</h1>
        <p>University of Baguio - Physical Education Office</p>
        <p>Generated on: {{ $generated_at }}</p>
    </div>

    @if(!empty($filters))
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if(isset($filters['category']) && $filters['category'])
            @php
                $category = \App\Models\EquipmentCategory::find($filters['category']);
                $categoryName = $category ? $category->name : 'Unknown';
            @endphp
            <p><strong>Category:</strong> {{ $categoryName }}</p>
        @endif
        @if(isset($filters['report_type']) && $filters['report_type'])
            <p><strong>Report Type:</strong> {{ ucfirst($filters['report_type']) }}</p>
        @endif
        @if(isset($filters['equipment_type']) && $filters['equipment_type'])
            @php
                $equipmentType = \App\Models\EquipmentType::find($filters['equipment_type']);
                $equipmentTypeName = $equipmentType ? $equipmentType->name : 'Unknown';
            @endphp
            <p><strong>Equipment Type:</strong> {{ $equipmentTypeName }}</p>
        @endif
        @if(isset($filters['search']) && $filters['search'])
            <p><strong>Search:</strong> {{ $filters['search'] }}</p>
        @endif
    </div>
    @endif

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
            @foreach($equipment as $item)
            <tr>
                <td>{{ $item->model ?? 'N/A' }}</td>
                <td>{{ $item->brand ?? 'N/A' }}</td>
                <td>{{ $item->category ? $item->category->name : 'N/A' }}</td>
                <td>{{ $item->equipmentType ? $item->equipmentType->name : 'N/A' }}</td>
                <td>{{ $item->quantity_available > 0 ? 'Available' : 'Unavailable' }}</td>
                <td>{{ $item->quantity_total }}</td>
                <td>{{ $item->quantity_available }}</td>
                <td>{{ $item->location ?? 'N/A' }}</td>
                <td>{{ $item->updated_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Equipment: {{ $equipment->count() }}</p>
        <p>This report was generated automatically by the SEMS system.</p>
    </div>
</body>
</html>
