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
            margin-bottom: 30px;
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
            color: #333;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
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
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            font-size: 10px;
        }
        .wishlist-count {
            font-weight: bold;
            color: #e53e3e;
        }
        .category-tag {
            background-color: #3182ce;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .status-tag {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-available {
            background-color: #38a169;
            color: white;
        }
        .status-unavailable {
            background-color: #e53e3e;
            color: white;
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
        @if(isset($filters['search']) && $filters['search'])
            <p><strong>Search:</strong> {{ $filters['search'] }}</p>
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
        @if(isset($filters['sort']) && $filters['sort'])
            <p><strong>Sort By:</strong> {{ ucfirst(str_replace('_', ' ', $filters['sort'])) }} 
               ({{ (($filters['direction'] ?? 'desc') === 'desc') ? 'Highest First' : 'Lowest First' }})</p>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Brand/Model</th>
                <th>Category</th>
                <th>Type</th>
                <th>Wishlist Count</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipment as $item)
                <tr>
                    <td>
                        <strong>{{ $item->brand }} {{ $item->model }}</strong>
                    </td>
                    <td>
                        <span class="category-tag">{{ $item->category->name ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <span class="type-tag">{{ $item->equipmentType ? $item->equipmentType->name : 'N/A' }}</span>
                    </td>
                    <td>
                        <span class="wishlist-count">{{ $item->wishlist_count ?? 0 }} wishes</span>
                    </td>
                    <td>
                        {{ $item->instances->where('status', 'available')->count() }}/{{ $item->instances->count() }}
                    </td>
                    <td>
                        @php
                            $availableCount = $item->instances->where('status', 'available')->count();
                            $totalCount = $item->instances->count();
                            $status = $availableCount > 0 ? 'Available' : 'Unavailable';
                            $statusClass = $availableCount > 0 ? 'status-available' : 'status-unavailable';
                        @endphp
                        <span class="status-tag {{ $statusClass }}">{{ $status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        No wishlisted equipment found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the SEMS system.</p>
        <p>Total items: {{ $equipment->count() }}</p>
    </div>
</body>
</html>
