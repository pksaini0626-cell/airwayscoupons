<div>
    <!-- STATS CARDS GRID -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 35px;">
        <div class="admin-card" style="margin-bottom: 0;">
            <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Coupons</div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #0284c7; margin: 6px 0;">{{ $stats['total_coupons'] }}</div>
            <div style="font-size: 0.8rem; color: #10b981;">{{ $stats['active_coupons'] }} Active Live</div>
        </div>
        <div class="admin-card" style="margin-bottom: 0;">
            <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Featured Deals</div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #f59e0b; margin: 6px 0;">{{ $stats['featured_coupons'] }}</div>
            <div style="font-size: 0.8rem; color: #64748b;">Top Homepage Cards</div>
        </div>
        <div class="admin-card" style="margin-bottom: 0;">
            <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Active Airlines</div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin: 6px 0;">{{ $stats['total_airlines'] }}</div>
            <div style="font-size: 0.8rem; color: #64748b;">Delta, United, AA & More</div>
        </div>
        <div class="admin-card" style="margin-bottom: 0;">
            <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Code Clicks</div>
            <div style="font-size: 2.2rem; font-weight: 800; color: #10b981; margin: 6px 0;">{{ number_format($stats['total_clicks']) }}</div>
            <div style="font-size: 0.8rem; color: #10b981;">Hotline Code Reveals</div>
        </div>
    </div>

    <!-- RECENT COUPONS TABLE -->
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 1.2rem; font-weight: 800;">Recently Added Coupons</h3>
            <a href="{{ url('/admin/coupons') }}" class="btn-admin">Manage All Coupons</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Airline</th>
                    <th>Title & Code</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Clicks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentCoupons as $coupon)
                    <tr>
                        <td>
                            <strong>{{ $coupon->airline->name ?? 'General' }}</strong>
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $coupon->title }}</div>
                            <span style="font-family: monospace; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $coupon->code }}</span>
                        </td>
                        <td>
                            <span class="badge-status badge-warning">{{ $coupon->discount_label }}</span>
                        </td>
                        <td>
                            @if($coupon->is_active)
                                <span class="badge-status badge-success">Active</span>
                            @else
                                <span class="badge-status badge-gray">Inactive</span>
                            @endif
                        </td>
                        <td><strong>{{ $coupon->clicks_count }}</strong> reveals</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
