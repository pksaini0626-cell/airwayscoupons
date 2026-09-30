<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::with(['airline', 'category'])->where('is_active', true);

        // Search query
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('discount_label', 'like', "%{$search}%")
                  ->orWhereHas('airline', function ($aq) use ($search) {
                      $aq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Airline
        if ($request->filled('airline')) {
            $airlineSlug = $request->input('airline');
            $query->whereHas('airline', function ($aq) use ($airlineSlug) {
                $aq->where('slug', $airlineSlug);
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($cq) use ($catSlug) {
                $cq->where('slug', $catSlug);
            });
        }

        $coupons = $query->orderBy('is_featured', 'desc')
                        ->latest()
                        ->paginate(12)
                        ->withQueryString();

        $featuredCoupons = Coupon::with(['airline', 'category'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)
            ->get();

        $airlines = Airline::where('is_active', true)->orderBy('is_popular', 'desc')->get();
        $categories = CouponCategory::where('is_active', true)->get();

        $settings = [
            'agent_phone' => SiteSetting::getByKey('agent_phone', '+1 (800) 555-0199'),
            'agent_phone_display' => SiteSetting::getByKey('agent_phone_display', '+1 (800) 555-0199'),
            'header_announcement' => SiteSetting::getByKey('header_announcement', '🇺🇸 USA Exclusive Unadvertised Phone Deals - Save Up to $150 per ticket!'),
            'support_hours' => SiteSetting::getByKey('support_hours', '24/7 Live Booking Support'),
            'footer_disclaimer' => SiteSetting::getByKey('footer_disclaimer', 'AirwaysCoupons is an independent travel voucher and phone assistance service.'),
        ];

        return view('home.index', compact('coupons', 'featuredCoupons', 'airlines', 'categories', 'settings'));
    }

    public function trackClick($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon->increment('clicks_count');
            return response()->json(['success' => true, 'clicks' => $coupon->clicks_count]);
        }
        return response()->json(['success' => false], 404);
    }
}
