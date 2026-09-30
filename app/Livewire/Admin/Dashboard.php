<?php

namespace App\Livewire\Admin;

use App\Models\Airline;
use App\Models\Coupon;
use App\Models\CouponCategory;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_coupons' => Coupon::count(),
            'active_coupons' => Coupon::where('is_active', true)->count(),
            'featured_coupons' => Coupon::where('is_featured', true)->count(),
            'total_airlines' => Airline::count(),
            'total_categories' => CouponCategory::count(),
            'total_clicks' => Coupon::sum('clicks_count'),
        ];

        $recentCoupons = Coupon::with('airline')->latest()->take(5)->get();

        return view('livewire.admin.dashboard', compact('stats', 'recentCoupons'))
            ->layout('layouts.admin', ['title' => 'Dashboard']);
    }
}
