<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SEMS Notification Request</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; margin:0; padding:0; background:#f6f7fb; color:#111827; }
        .container { max-width: 640px; margin: 0 auto; padding: 24px; }
        .card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04); }
        .header { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #fff; padding: 20px 24px; text-align: center; }
        .brand { display:flex; align-items:center; justify-content:center; gap:10px; font-weight:800; letter-spacing:0.3px; }
        .content { padding: 24px; }
        .kicker { font-size:12px; text-transform:uppercase; letter-spacing:0.08em; color:#6b7280; margin-bottom:6px; }
        h1 { font-size:20px; margin: 0 0 4px; }
        p { margin: 0 0 12px; line-height:1.55; }
        .details { background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:12px 14px; margin: 14px 0; }
        .details .row { display:flex; justify-content:space-between; gap:12px; font-size:14px; }
        .muted { color:#6b7280; }
        .footer { text-align:center; color:#6b7280; font-size:12px; padding: 18px; }
        .note { background:#fff7ed; border:1px solid #fed7aa; color:#92400e; padding:10px 12px; border-radius:8px; font-size:13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="brand">SEMS • Sports Equipment Management System</div>
            </div>
            <div class="content">
                <div class="kicker">Notification request received</div>
                <h1>We'll notify you when it's available</h1>
                <p>Thanks for your interest in <strong>{{ $equipmentName }}</strong>. We'll send you an email once this item becomes available for reservation.</p>

                <div class="details">
                    <div class="row"><span class="muted">Equipment</span><span>{{ $equipmentName }}</span></div>
                    @if($categoryName)
                        <div class="row"><span class="muted">Category</span><span>{{ $categoryName }}</span></div>
                    @endif
                    @if($typeName)
                        <div class="row"><span class="muted">Type</span><span>{{ $typeName }}</span></div>
                    @endif
                </div>

                <p class="note">No account or signup needed. We don't store your email—you're receiving this message because you requested to get notified. If this wasn't you, you can safely ignore this message.</p>

                <p class="muted">Tip: You can also browse other available equipment on the SEMS portal.</p>
            </div>
            <div class="footer">© {{ date('Y') }} University of Baguio • SEMS</div>
        </div>
    </div>
</body>
</html>


