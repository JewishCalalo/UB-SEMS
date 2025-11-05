<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Equipment Reservation Overdue - {{ $reservation->reservation_code }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .alert-box h3 {
            color: #dc2626;
            margin-top: 0;
            font-size: 18px;
        }
        .reservation-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .reservation-details h3 {
            color: #374151;
            margin-top: 0;
            font-size: 16px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #374151;
        }
        .detail-value {
            color: #6b7280;
        }
        .equipment-list {
            background-color: #f3f4f6;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }
        .equipment-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #d1d5db;
        }
        .equipment-item:last-child {
            border-bottom: none;
        }
        .action-required {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .action-required h3 {
            color: #d97706;
            margin-top: 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .contact-info {
            background-color: #e0f2fe;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .contact-info h4 {
            color: #0369a1;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/ub-logo.png')) }}" alt="SEMS Logo" style="max-height: 50px; display: block; margin: 0 auto 10px;">
            <h1>Equipment Reservation Overdue</h1>
            <p>Reservation Code: {{ $reservation->reservation_code }}</p>
        </div>

        <div class="content">
            <div class="alert-box">
                <h3>URGENT: Your Equipment Reservation is Overdue</h3>
                <p>Your equipment reservation is <strong>{{ $daysOverdue }} day(s) overdue</strong>. Immediate action is required to return the equipment and avoid further penalties.</p>
            </div>

            <div class="reservation-details">
                <h3>Reservation Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Reservation Code:</span>
                    <span class="detail-value">{{ $reservation->reservation_code }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">{{ $reservation->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $reservation->email }}</span>
                </div>
                @if($reservation->pickup_date)
                <div class="detail-row">
                    <span class="detail-label">Pickup Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($reservation->pickup_date)->format('F j, Y') }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Due Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($reservation->return_date)->format('F j, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Days Overdue:</span>
                    <span class="detail-value" style="color: #dc2626; font-weight: 600;">{{ $daysOverdue }} day(s)</span>
                </div>
            </div>

            @if($reservation->items->count() > 0)
                <div class="equipment-list">
                    <h3>Equipment to be Returned</h3>
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
                                @foreach($reservation->items as $item)
                                    @foreach($item->reservationItemInstances as $reservationItemInstance)
                                        @php
                                            $instance = $reservationItemInstance->equipmentInstance;
                                        @endphp
                                        <tr>
                                            <td style="padding: 8px; border: 1px solid #dee2e6; font-weight: bold;">{{ $instance->instance_code ?: 'Instance #' . $instance->id }}</td>
                                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                                <div style="font-weight: bold;">{{ $item->equipment->category->name ?? 'N/A' }}</div>
                                                <div style="color: #6c757d; font-size: 12px;">{{ $item->equipment->equipmentType->name ?? 'No type specified' }}</div>
                                            </td>
                                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                                <span style="background-color: #cce5ff; color: #004085; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                    {{ ucfirst($instance->condition) }}
                                                </span>
                                            </td>
                                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                                @if($reservationItemInstance->pickup_condition)
                                                    <span style="background-color: #d4edda; color: #155724; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                                                        {{ ucfirst(str_replace('_', ' ', $reservationItemInstance->pickup_condition)) }}
                                                    </span>
                                                @else
                                                    <span style="color: #6c757d;">Not recorded</span>
                                                @endif
                                            </td>
                                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                                @if($reservationItemInstance->pickup_notes)
                                                    <div style="font-size: 12px; color: #495057;">{{ $reservationItemInstance->pickup_notes }}</div>
                                                @else
                                                    <span style="color: #6c757d;">No notes</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="action-required">
                <h3>Immediate Action Required</h3>
                <ul>
                    <li><strong>Return the equipment immediately</strong> to the equipment management office</li>
                    <li>Bring this email or your reservation code for verification</li>
                    <li>Ensure all equipment is in good condition</li>
                    <li>Contact us if you need to arrange a return time</li>
                </ul>
            </div>

            <div class="contact-info">
                <h4>Need Help?</h4>
                <p>If you have any questions or need to arrange a return time, please contact the equipment management office immediately.</p>
                <p><strong>Contact:</strong> Equipment Management Office<br>
                <strong>Hours:</strong> Monday - Friday, 8:00 AM - 5:00 PM</p>
            </div>

            <div style="background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; color: #dc2626; font-weight: 600;">
                    <strong>Important:</strong> Continued failure to return equipment may result in account restrictions and additional penalties.
                </p>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated notification from the Equipment Management System.</p>
            <p>Please do not reply to this email. For assistance, contact the equipment management office.</p>
        </div>
    </div>
</body>
</html>
