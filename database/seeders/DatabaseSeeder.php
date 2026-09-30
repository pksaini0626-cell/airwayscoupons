<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@airwayscoupons.com'],
            [
                'name' => 'Admin Specialist',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // 2. Default Site Settings
        $settings = [
            'site_name' => 'Airways Coupons',
            'agent_phone' => '+1 (800) 555-0199',
            'agent_phone_display' => '+1 (800) 555-0199',
            'header_announcement' => '🇺🇸 USA Exclusive Unadvertised Phone Deals - Save Up to $150 per ticket!',
            'support_hours' => '24/7 Live Booking Support',
            'footer_disclaimer' => 'AirwaysCoupons is an independent travel voucher and phone assistance service. We assist customers in redeeming private agent-only airline promotional vouchers over the phone.',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::setKey($key, $val);
        }

        // 3. Create Categories
        $categories = [
            [
                'name' => 'Domestic Flights',
                'slug' => 'domestic-flights',
                'icon' => '🇺🇸',
                'description' => 'Discounts on roundtrip and one-way flights within the United States & Canada.',
            ],
            [
                'name' => 'International Deals',
                'slug' => 'international-deals',
                'icon' => '✈️',
                'description' => 'Save big on transatlantic, transpacific, and global overseas flights.',
            ],
            [
                'name' => 'Business & First Class',
                'slug' => 'business-first-class',
                'icon' => '👑',
                'description' => 'Premium cabin upgrades, lie-flat seat vouchers, and luxury flight deals.',
            ],
            [
                'name' => 'Last Minute Offers',
                'slug' => 'last-minute-offers',
                'icon' => '⚡',
                'description' => 'Exclusive emergency and same-week travel coupon codes.',
            ],
            [
                'name' => 'Holiday & Vacation Sales',
                'slug' => 'holiday-vacation-sales',
                'icon' => '🏖️',
                'description' => 'Seasonal holiday promo codes for family & group travel.',
            ],
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $createdCat = CouponCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
            $categoryMap[$cat['slug']] = $createdCat->id;
        }

        // 4. Create Airlines
        $airlines = [
            ['name' => 'Delta Air Lines', 'slug' => 'delta-air-lines', 'code' => 'DL', 'logo' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=120&auto=format&fit=crop&q=80', 'is_popular' => true],
            ['name' => 'United Airlines', 'slug' => 'united-airlines', 'code' => 'UA', 'logo' => 'https://images.unsplash.com/photo-1542296332-2e4473faf563?w=120&auto=format&fit=crop&q=80', 'is_popular' => true],
            ['name' => 'American Airlines', 'slug' => 'american-airlines', 'code' => 'AA', 'logo' => 'https://images.unsplash.com/photo-1506015391300-4802dc74de2e?w=120&auto=format&fit=crop&q=80', 'is_popular' => true],
            ['name' => 'Southwest Airlines', 'slug' => 'southwest-airlines', 'code' => 'WN', 'logo' => 'https://images.unsplash.com/photo-1519074069444-1ba4eff56024?w=120&auto=format&fit=crop&q=80', 'is_popular' => true],
            ['name' => 'Qatar Airways', 'slug' => 'qatar-airways', 'code' => 'QR', 'logo' => 'https://images.unsplash.com/photo-1524592714635-d77511a4834d?w=120&auto=format&fit=crop&q=80', 'is_popular' => true],
            ['name' => 'Emirates', 'slug' => 'emirates', 'code' => 'EK', 'logo' => 'https://images.unsplash.com/photo-1570710891163-6d3b5c47248b?w=120&auto=format&fit=crop&q=80', 'is_popular' => true],
            ['name' => 'British Airways', 'slug' => 'british-airways', 'code' => 'BA', 'logo' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=120&auto=format&fit=crop&q=80', 'is_popular' => false],
            ['name' => 'Lufthansa', 'slug' => 'lufthansa', 'code' => 'LH', 'logo' => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=120&auto=format&fit=crop&q=80', 'is_popular' => false],
            ['name' => 'JetBlue Airways', 'slug' => 'jetblue-airways', 'code' => 'B6', 'logo' => 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?w=120&auto=format&fit=crop&q=80', 'is_popular' => false],
            ['name' => 'Alaska Airlines', 'slug' => 'alaska-airlines', 'code' => 'AS', 'logo' => 'https://images.unsplash.com/photo-1583508915901-b5f84c1dcde1?w=120&auto=format&fit=crop&q=80', 'is_popular' => false],
        ];

        $airlineMap = [];
        foreach ($airlines as $air) {
            $createdAir = Airline::updateOrCreate(['slug' => $air['slug']], $air);
            $airlineMap[$air['slug']] = $createdAir->id;
        }

        // 5. Create Coupons
        $coupons = [
            [
                'airline_id' => $airlineMap['delta-air-lines'],
                'coupon_category_id' => $categoryMap['domestic-flights'],
                'title' => 'Exclusive $150 OFF USA Roundtrip Delta Flights',
                'code' => 'DELTA150USA',
                'discount_label' => '$150 INSTANT OFF',
                'description' => 'Save up to $150 on roundtrip domestic travel with Delta Air Lines. Valid when booking through our live telephone booking desk.',
                'terms' => 'Must be redeemed by phone with an agent. Minimum 2 passengers or roundtrip booking required.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(45)->toDateString(),
                'is_featured' => true,
                'is_active' => true,
                'clicks_count' => 342,
            ],
            [
                'airline_id' => $airlineMap['united-airlines'],
                'coupon_category_id' => $categoryMap['international-deals'],
                'title' => 'Save Up to 25% OFF Transatlantic & Global United Routes',
                'code' => 'UNITED25INTL',
                'discount_label' => '25% OFF GLOBAL',
                'description' => 'Unlock unadvertised telephone agent discounts for international flights across Europe, Asia, and Latin America.',
                'terms' => 'Available on select economy and premium economy routes. Call agent with promo code to redeem.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(30)->toDateString(),
                'is_featured' => true,
                'is_active' => true,
                'clicks_count' => 518,
            ],
            [
                'airline_id' => $airlineMap['american-airlines'],
                'coupon_category_id' => $categoryMap['last-minute-offers'],
                'title' => 'Emergency & Same-Week Flight Rebate: $120 Voucher',
                'code' => 'AA120FAST',
                'discount_label' => '$120 REBATE',
                'description' => 'Need to fly today or within 7 days? Claim your emergency phone booking credit on American Airlines.',
                'terms' => 'Applies to bookings departing within 7 days. Phone redemption only.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(15)->toDateString(),
                'is_featured' => true,
                'is_active' => true,
                'clicks_count' => 289,
            ],
            [
                'airline_id' => $airlineMap['qatar-airways'],
                'coupon_category_id' => $categoryMap['business-first-class'],
                'title' => 'Luxury Cabin Special: $300 OFF Qatar Business Class',
                'code' => 'QATAR300BIZ',
                'discount_label' => '$300 BIZ OFF',
                'description' => 'Fly world-class Qsuite with $300 instant discount per ticket when reserving via phone agent.',
                'terms' => 'Valid for Business and First Class reservations. One code per itinerary.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(60)->toDateString(),
                'is_featured' => true,
                'is_active' => true,
                'clicks_count' => 412,
            ],
            [
                'airline_id' => $airlineMap['southwest-airlines'],
                'coupon_category_id' => $categoryMap['holiday-vacation-sales'],
                'title' => 'Family & Group Travel Special: Free 2nd Bag + $80 Off',
                'code' => 'SW80FAMILY',
                'discount_label' => '$80 OFF + BAGS',
                'description' => 'Get $80 instant phone discount plus priority family boarding assistance on Southwest Airlines.',
                'terms' => 'Phone booking exclusive. Valid for 2 or more travelers.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(20)->toDateString(),
                'is_featured' => false,
                'is_active' => true,
                'clicks_count' => 195,
            ],
            [
                'airline_id' => $airlineMap['emirates'],
                'coupon_category_id' => $categoryMap['international-deals'],
                'title' => '$200 Discount on Emirates Long-Haul Trips',
                'code' => 'EK200GLOBAL',
                'discount_label' => '$200 OFF FLY',
                'description' => 'Fly to Dubai, Asia, or Africa with Emirates and enjoy $200 phone agent discount.',
                'terms' => 'Valid on round-trip international itineraries. Call desk to apply code.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(40)->toDateString(),
                'is_featured' => true,
                'is_active' => true,
                'clicks_count' => 376,
            ],
            [
                'airline_id' => $airlineMap['british-airways'],
                'coupon_category_id' => $categoryMap['international-deals'],
                'title' => 'London & Europe Special: $100 OFF BA Flights',
                'code' => 'BA100LONDON',
                'discount_label' => '$100 SAVINGS',
                'description' => 'Planning a trip to London or Europe? Mention this code to your booking agent for $100 off.',
                'terms' => 'Valid for flights originating in North America to UK/Europe.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(25)->toDateString(),
                'is_featured' => false,
                'is_active' => true,
                'clicks_count' => 143,
            ],
            [
                'airline_id' => $airlineMap['jetblue-airways'],
                'coupon_category_id' => $categoryMap['domestic-flights'],
                'title' => 'Coast-to-Coast JetBlue Deal: $60 Instant Coupon',
                'code' => 'JET60COAST',
                'discount_label' => '$60 INSTANT',
                'description' => 'Enjoy Mint or even core economy seats with $60 off per seat on non-stop cross-country flights.',
                'terms' => 'Agent booking hotline exclusive voucher.',
                'phone_number' => '+1 (800) 555-0199',
                'expiry_date' => now()->addDays(35)->toDateString(),
                'is_featured' => false,
                'is_active' => true,
                'clicks_count' => 210,
            ],
        ];

        foreach ($coupons as $coup) {
            Coupon::updateOrCreate(
                ['code' => $coup['code']],
                $coup
            );
        }
    }
}
