<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 24px 28px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #111827;
            font-size: 10.5px;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #eef2ff;
            color: #111827;
            border: 1px solid #c7d2fe;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            line-height: 1.1;
        }

        .header p {
            margin: 4px 0 0;
            opacity: 0.9;
        }

        .meta {
            margin-top: 8px;
            font-size: 10px;
            opacity: 0.9;
        }

        .grid-4 {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-bottom: 10px;
        }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 14px;
            vertical-align: top;
        }

        .label {
            color: #6b7280;
            font-size: 10px;
            margin: 0;
        }

        .value {
            font-size: 24px;
            font-weight: 700;
            margin: 8px 0 2px;
        }

        .subtext {
            color: #9ca3af;
            font-size: 10px;
            margin: 0;
        }

        .section-row {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-top: 4px;
        }

        .panel {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
            background: #fff;
            vertical-align: top;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #e5e7eb;
            padding: 7px 8px;
            text-align: left;
            vertical-align: top;
        }

        .report-table th {
            background: #f9fafb;
            font-weight: 700;
            color: #374151;
        }

        .legend {
            margin-top: 10px;
            font-size: 10px;
        }

        .legend span {
            display: inline-block;
            margin-right: 10px;
        }

        .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            margin-right: 5px;
            vertical-align: middle;
        }

        .small-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-top: 8px;
        }

        .mini-card {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
        }

        .mini-card p {
            margin: 0;
        }

        .mini-label {
            font-size: 10px;
        }

        .mini-value {
            font-size: 18px;
            font-weight: 700;
            margin-top: 6px;
        }

        .two-col-cell {
            width: 50%;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Zuro Lost and Found</h1>
        <div class="meta">Date and Time : {{ $generatedAt->format('F j, Y g:i A') }}</div>
    </div>

    <table class="grid-4">
        <tr>
            <td class="card">
                <p class="label">Total Items</p>
                <div class="value">{{ $totalItems }}</div>
                <p class="subtext">{{ $foundItems }} found, {{ $lostItems }} lost</p>
            </td>
            <td class="card">
                <p class="label">Total Claims</p>
                <div class="value">{{ $pendingClaims + $verifiedClaims + $rejectedClaims }}</div>
                <p class="subtext">{{ $pendingClaims }} pending review</p>
            </td>
            <td class="card">
                <p class="label">Total Users</p>
                <div class="value">{{ $totalUsers }}</div>
                <p class="subtext">{{ $staffUsers }} staff, {{ $adminUsers }} admins</p>
            </td>
            <td class="card">
                <p class="label">Success Rate</p>
                <div class="value">{{ number_format($successRate, 1) }}%</div>
                <p class="subtext">Claims verified</p>
            </td>
        </tr>
    </table>

    <table class="section-row">
        <tr>
            <td class="panel two-col-cell">
                <div class="section-title">Item Status Distribution</div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lost</td>
                            <td>{{ $lostItems }}</td>
                            <td>Items reported missing</td>
                        </tr>
                        <tr>
                            <td>Found</td>
                            <td>{{ $foundItems }}</td>
                            <td>Items waiting for claim</td>
                        </tr>
                        <tr>
                            <td>Claimed</td>
                            <td>{{ $claimedItems }}</td>
                            <td>Items already claimed</td>
                        </tr>
                        <tr>
                            <td>Returned</td>
                            <td>{{ $itemsReturned }}</td>
                            <td>Items confirmed returned</td>
                        </tr>
                    </tbody>
                </table>
                <div class="legend">
                    <span><i class="dot" style="background:#ef4444;"></i>Lost</span>
                    <span><i class="dot" style="background:#3b82f6;"></i>Found</span>
                    <span><i class="dot" style="background:#f59e0b;"></i>Claimed</span>
                    <span><i class="dot" style="background:#10b981;"></i>Returned</span>
                </div>
            </td>
            <td class="panel two-col-cell">
                <div class="section-title">Claim Status Distribution</div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pending</td>
                            <td>{{ $pendingClaims }}</td>
                            <td>Awaiting review</td>
                        </tr>
                        <tr>
                            <td>Verified</td>
                            <td>{{ $verifiedClaims }}</td>
                            <td>Accepted claims</td>
                        </tr>
                        <tr>
                            <td>Rejected</td>
                            <td>{{ $rejectedClaims }}</td>
                            <td>Declined claims</td>
                        </tr>
                    </tbody>
                </table>
                <div class="legend">
                    <span><i class="dot" style="background:#f59e0b;"></i>Pending</span>
                    <span><i class="dot" style="background:#10b981;"></i>Verified</span>
                    <span><i class="dot" style="background:#ef4444;"></i>Rejected</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="section-row">
        <tr>
            <td class="panel two-col-cell">
                <div class="section-title">Items by Category</div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Count</th>
                            <th>Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $categoryTotal = max(1, collect($itemCategories)->sum('count')); @endphp
                        @foreach ($itemCategories as $category)
                            <tr>
                                <td>{{ $category['name'] }}</td>
                                <td>{{ $category['count'] }}</td>
                                <td>{{ number_format(($category['count'] / $categoryTotal) * 100, 1) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td class="panel two-col-cell">
                <div class="section-title">7-Day Activity Trend</div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Claims</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activityLabels as $index => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $activityItems[$index] }}</td>
                                <td>{{ $activityClaims[$index] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <table class="small-grid">
        <tr>
            <td class="mini-card" style="background:#fff7ed; border-color:#fde68a; width:33.33%;">
                <p class="mini-label" style="color:#f97316;">Pending Claims</p>
                <p class="mini-value">{{ $pendingClaims }}</p>
            </td>
            <td class="mini-card" style="background:#ecfdf5; border-color:#a7f3d0; width:33.33%;">
                <p class="mini-label" style="color:#10b981;">Items Returned</p>
                <p class="mini-value">{{ $itemsReturned }}</p>
            </td>
            <td class="mini-card" style="background:#fef2f2; border-color:#fecaca; width:33.33%;">
                <p class="mini-label" style="color:#ef4444;">Active Lost Items</p>
                <p class="mini-value">{{ $activeLostItems }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
