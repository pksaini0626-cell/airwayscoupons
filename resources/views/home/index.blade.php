@extends('layouts.app')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="hero-header">
                <div class="hero-tag">
                    <span>🏷️ USA Secret Airline Promo Codes {{ date('Y') }}</span>
                </div>
                <h1 class="hero-title">
                    Unlock Exclusive Airline <br>
                    <span class="text-gradient">Secret Coupons & Phone Deals</span>
                </h1>
                <p class="hero-subtitle">
                    Reveal your coupon code below, copy it, and call our USA certified travel agents at 
                    <strong style="color: white;">{{ $settings['agent_phone_display'] ?? '+1 (800) 555-0199' }}</strong> to claim up to <strong style="color: #38bdf8;">$150 OFF</strong> per flight ticket!
                </p>

                <!-- HERO CALL CARD -->
                <div class="hero-cta-card">
                    <div class="cta-text">
                        <h3>Ready to Lock in Your Savings?</h3>
                        <p>Speak to a live booking specialist 24/7 to apply private agent promotional codes instantly.</p>
                    </div>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['agent_phone'] ?? '+18005550199') }}" class="btn-hero-call">
                        📞 Call {{ $settings['agent_phone_display'] ?? '+1 (800) 555-0199' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH & FILTER BAR SECTION -->
    <div class="container filter-section">
        <div class="filter-card">
            <form action="{{ url('/') }}" method="GET" class="filter-form">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control-input" placeholder="🔍 Search airline name, code, or offer (e.g. Delta, UNITED150)...">
                </div>
                <div>
                    <select name="airline" class="form-control-input">
                        <option value="">All Airlines</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->slug }}" {{ request('airline') == $airline->slug ? 'selected' : '' }}>
                                {{ $airline->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="category" class="form-control-input">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-search">Filter Deals</button>
                    @if(request()->hasAny(['search', 'airline', 'category']))
                        <a href="{{ url('/') }}" class="form-control-input" style="background: #f1f5f9; text-align: center; font-weight: 600; text-decoration: none;">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- FEATURED / HOT DEALS -->
    @if($featuredCoupons->count() > 0 && !request()->hasAny(['search', 'airline', 'category']))
        <section class="container" style="margin-bottom: 50px;">
            <div class="section-header">
                <span class="section-subtitle">🔥 Unadvertised Agent Deals</span>
                <h2 class="section-title">Top Featured Airline Secret Coupons</h2>
            </div>
            <div class="coupons-grid">
                @foreach($featuredCoupons as $coupon)
                    <div class="coupon-card featured-card">
                        <div class="badge-featured">Featured Deal</div>
                        <div>
                            <div class="coupon-top">
                                <div class="airline-info">
                                    <div class="airline-logo-box">
                                        @if($coupon->airline->logo)
                                            <img src="{{ $coupon->airline->logo }}" alt="{{ $coupon->airline->name }}">
                                        @else
                                            <span>✈️</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="airline-name">{{ $coupon->airline->name }}</div>
                                        <div class="category-tag">{{ $coupon->category->icon ?? '🏷️' }} {{ $coupon->category->name ?? 'General Deal' }}</div>
                                    </div>
                                </div>
                                <div class="discount-badge">{{ $coupon->discount_label }}</div>
                            </div>
                            <h3 class="coupon-title">{{ $coupon->title }}</h3>
                            <p class="coupon-desc">{{ $coupon->description }}</p>
                        </div>
                        <div>
                            <div class="code-box">
                                <span class="code-text">{{ $coupon->code }}</span>
                                <button type="button" class="btn-copy-code" onclick="copyAndOpenModal('{{ $coupon->code }}', '{{ addslashes($coupon->title) }}', '{{ $coupon->phone_number ?? $settings['agent_phone_display'] }}', {{ $coupon->id }})">
                                    Copy & Call
                                </button>
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $coupon->phone_number ?? $settings['agent_phone']) }}" class="btn-card-call">
                                📞 Call {{ $coupon->phone_number ?? $settings['agent_phone_display'] }} to Redeem
                            </a>
                            <p class="terms-hint">{{ $coupon->terms ?? 'Phone booking required with live agent.' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- ALL COUPONS GRID -->
    <section class="container" id="dealsSection" style="margin-bottom: 70px;">
        <div class="section-header">
            <span class="section-subtitle">🏷️ Verified Promo Codes</span>
            <h2 class="section-title">All Available Airline Coupon Codes</h2>
        </div>

        @if($coupons->count() > 0)
            <div class="coupons-grid">
                @foreach($coupons as $coupon)
                    <div class="coupon-card {{ $coupon->is_featured ? 'featured-card' : '' }}">
                        @if($coupon->is_featured)
                            <div class="badge-featured">Hot Deal</div>
                        @endif
                        <div>
                            <div class="coupon-top">
                                <div class="airline-info">
                                    <div class="airline-logo-box">
                                        @if($coupon->airline->logo)
                                            <img src="{{ $coupon->airline->logo }}" alt="{{ $coupon->airline->name }}">
                                        @else
                                            <span>✈️</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="airline-name">{{ $coupon->airline->name }}</div>
                                        <div class="category-tag">{{ $coupon->category->icon ?? '🏷️' }} {{ $coupon->category->name ?? 'Deal' }}</div>
                                    </div>
                                </div>
                                <div class="discount-badge">{{ $coupon->discount_label }}</div>
                            </div>
                            <h3 class="coupon-title">{{ $coupon->title }}</h3>
                            <p class="coupon-desc">{{ $coupon->description }}</p>
                        </div>
                        <div>
                            <div class="code-box">
                                <span class="code-text">{{ $coupon->code }}</span>
                                <button type="button" class="btn-copy-code" onclick="copyAndOpenModal('{{ $coupon->code }}', '{{ addslashes($coupon->title) }}', '{{ $coupon->phone_number ?? $settings['agent_phone_display'] }}', {{ $coupon->id }})">
                                    Copy & Call
                                </button>
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $coupon->phone_number ?? $settings['agent_phone']) }}" class="btn-card-call">
                                📞 Call {{ $coupon->phone_number ?? $settings['agent_phone_display'] }} to Redeem
                            </a>
                            <p class="terms-hint">
                                Expiry: {{ $coupon->expiry_date ? $coupon->expiry_date->format('M d, Y') : 'Limited Time' }} • {{ $coupon->terms ?? 'Phone booking desk only' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: center; margin-top: 30px;">
                {{ $coupons->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; border: 1px solid var(--border-color);">
                <div style="font-size: 3rem; margin-bottom: 12px;">🔍</div>
                <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--dark); margin-bottom: 8px;">No Coupons Found Matching Your Criteria</h3>
                <p style="color: var(--text-muted); margin-bottom: 20px;">Try clearing filters or search for another airline name.</p>
                <a href="{{ url('/') }}" class="btn-search" style="display: inline-block; text-decoration: none;">View All Coupons</a>
            </div>
        @endif
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-it-works" id="howItWorks">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Simple 3-Step Process</span>
                <h2 class="section-title">How to Redeem Your Airline Coupon</h2>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Select & Copy Code</h3>
                    <p class="step-desc">Browse secret coupon vouchers for your favorite airline (Delta, United, American, etc.) and click <strong>Copy & Call</strong>.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Call Live Booking Agent</h3>
                    <p class="step-desc">Connect directly with our 24/7 travel desk at <strong>{{ $settings['agent_phone_display'] ?? '+1 (800) 555-0199' }}</strong>.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Mention Code & Save</h3>
                    <p class="step-desc">Provide your unique promo code to the agent over the phone and enjoy instant savings of up to $150 off your flight!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- POPULAR AIRLINES -->
    <section class="container" id="popularAirlines" style="padding: 80px 0;">
        <div class="section-header">
            <span class="section-subtitle">Trusted Airline Partners</span>
            <h2 class="section-title">Coupons Available for Top Airlines</h2>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
            @foreach($airlines as $air)
                <a href="{{ url('/?airline=' . $air->slug) }}" style="background: white; padding: 16px 26px; border-radius: 50px; border: 1.5px solid var(--border-color); display: flex; align-items: center; gap: 12px; font-weight: 700; color: var(--dark); box-shadow: var(--shadow-sm); transition: all 0.2s ease;">
                    <span style="font-size: 1.2rem;">✈️</span>
                    <span>{{ $air->name }}</span>
                    <span style="background: #e0f2fe; color: #0284c7; padding: 2px 10px; border-radius: 20px; font-size: 0.8rem;">{{ $air->coupons_count ?? '' }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- WHY CALL US / AGENT BENEFITS -->
    <section style="background: #0f172a; color: white; padding: 80px 0;" id="whyUs">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle" style="color: #38bdf8;">Why Book via Phone Agent?</span>
                <h2 class="section-title" style="color: white;">Unadvertised Savings You Can't Find Online</h2>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card" style="background: #1e293b; border-color: #334155; color: white;">
                    <div class="benefit-icon">🤫</div>
                    <h3 class="benefit-title" style="color: white;">Private Agent Fares</h3>
                    <p class="benefit-desc" style="color: #94a3b8;">Airlines provide unpublished discount seat allocations specifically reserved for direct phone reservations.</p>
                </div>
                <div class="benefit-card" style="background: #1e293b; border-color: #334155; color: white;">
                    <div class="benefit-icon">🎧</div>
                    <h3 class="benefit-title" style="color: white;">24/7 Human Assistance</h3>
                    <p class="benefit-desc" style="color: #94a3b8;">Skip automated bots! Speak directly with friendly, knowledgeable USA booking experts anytime.</p>
                </div>
                <div class="benefit-card" style="background: #1e293b; border-color: #334155; color: white;">
                    <div class="benefit-icon">🧳</div>
                    <h3 class="benefit-title" style="color: white;">Free Baggage & Seat Perks</h3>
                    <p class="benefit-desc" style="color: #94a3b8;">Agents can often apply complimentary seat assignments and extra luggage allowances on qualifying promo vouchers.</p>
                </div>
                <div class="benefit-card" style="background: #1e293b; border-color: #334155; color: white;">
                    <div class="benefit-icon">⚡</div>
                    <h3 class="benefit-title" style="color: white;">Instant Code Application</h3>
                    <p class="benefit-desc" style="color: #94a3b8;">No confusing checkout forms or error screens — your discount code is validated instantly on the phone call.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQS -->
    <section class="faq-section" id="faqs">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Got Questions?</span>
                <h2 class="section-title">Frequently Asked Questions</h2>
            </div>
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I redeem an airline coupon code?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-answer">
                        Simply find your desired airline coupon code on our homepage, click "Copy & Call", and call our live booking desk at <strong>{{ $settings['agent_phone_display'] ?? '+1 (800) 555-0199' }}</strong>. Provide the code to the agent during your flight reservation to receive your discount.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Why do I need to call an agent to use these coupons?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-answer">
                        Many airlines provide exclusive, unadvertised private vouchers specifically for telephone reservations. These secret rates cannot be published directly on standard public checkout engines due to airline price parity rules.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Are there any fees to speak with an agent?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-answer">
                        No! Calling our booking hotline at <strong>{{ $settings['agent_phone_display'] ?? '+1 (800) 555-0199' }}</strong> is 100% free with no obligation to book until you are completely satisfied with your discounted quote.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Can I use these coupon codes for domestic and international flights?</span>
                        <span>▼</span>
                    </div>
                    <div class="faq-answer">
                        Yes! We offer coupon vouchers for both domestic routes across the USA/Canada and global international flights on major airlines like Delta, United, American, Qatar Airways, and Emirates.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
