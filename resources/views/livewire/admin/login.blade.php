<div style="width: 100%; max-width: 420px; padding: 20px;">
    <div class="admin-card" style="box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 28px;">
            <div style="width: 56px; height: 56px; background: #0284c7; color: white; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 12px;">
                ✈️
            </div>
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">Airways Admin Login</h2>
            <p style="font-size: 0.9rem; color: #64748b;">Sign in to manage airline coupons & site hotline</p>
        </div>

        <form wire:submit.prevent="login">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" wire:model="email" class="form-input" placeholder="admin@airwayscoupons.com">
                @error('email') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" wire:model="password" class="form-input" placeholder="••••••••">
                @error('password') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="display: flex; items-center; justify-content: space-between;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; cursor: pointer;">
                    <input type="checkbox" wire:model="remember"> Remember Me
                </label>
            </div>

            <button type="submit" class="btn-admin" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                Sign In to Dashboard
            </button>
        </form>

        <div style="margin-top: 20px; font-size: 0.8rem; text-align: center; color: #94a3b8;">
            Default Credentials: <strong>admin@airwayscoupons.com</strong> / <strong>password</strong>
        </div>
    </div>
</div>
