<div style="max-width: 800px;">
    @if(session()->has('message'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
            {{ session('message') }}
        </div>
    @endif

    <div class="admin-card">
        <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 20px;">Site Settings & Hotline Configuration</h3>

        <form wire:submit.prevent="saveSettings">
            <div class="form-group">
                <label class="form-label">Website Name</label>
                <input type="text" wire:model="site_name" class="form-input">
                @error('site_name') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Agent Hotline (Raw Tel Link) *</label>
                    <input type="text" wire:model="agent_phone" class="form-input" placeholder="+1 (800) 555-0199">
                    <span style="font-size: 0.78rem; color: #64748b;">Used for telephone href dialer links</span>
                    @error('agent_phone') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Agent Hotline Display Text *</label>
                    <input type="text" wire:model="agent_phone_display" class="form-input" placeholder="+1 (800) 555-0199">
                    <span style="font-size: 0.78rem; color: #64748b;">Text shown on buttons and headers</span>
                    @error('agent_phone_display') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Header Top Bar Announcement</label>
                <input type="text" wire:model="header_announcement" class="form-input" placeholder="🇺🇸 Exclusive USA Airline Discounts - Save Up to $150 per ticket!">
            </div>

            <div class="form-group">
                <label class="form-label">Support Hours Text</label>
                <input type="text" wire:model="support_hours" class="form-input" placeholder="24/7 Live Booking Support">
            </div>

            <div class="form-group">
                <label class="form-label">Footer Disclaimer Text</label>
                <textarea wire:model="footer_disclaimer" class="form-input" rows="3"></textarea>
            </div>

            <button type="submit" class="btn-admin" style="padding: 14px 28px; font-size: 1rem;">
                💾 Save Site Settings
            </button>
        </form>
    </div>
</div>
