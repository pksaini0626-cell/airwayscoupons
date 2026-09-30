<div>
    @if(session()->has('message'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
            {{ session('message') }}
        </div>
    @endif

    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; gap: 12px; flex: 1; max-width: 500px;">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-input" placeholder="Search coupon title, code, discount...">
                <select wire:model.live="airlineFilter" class="form-input" style="width: 180px;">
                    <option value="">All Airlines</option>
                    @foreach($airlines as $air)
                        <option value="{{ $air->id }}">{{ $air->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" wire:click="openCreateModal" class="btn-admin">
                ➕ Add New Coupon
            </button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Airline</th>
                    <th>Offer Title & Code</th>
                    <th>Discount Badge</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr>
                        <td>
                            <strong>{{ $coupon->airline->name ?? 'N/A' }}</strong>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $coupon->title }}</div>
                            <span style="font-family: monospace; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-weight: 800; font-size: 0.85rem;">
                                {{ $coupon->code }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status badge-warning">{{ $coupon->discount_label }}</span>
                        </td>
                        <td>{{ $coupon->category->name ?? 'General' }}</td>
                        <td>
                            <button type="button" wire:click="toggleFeatured({{ $coupon->id }})" style="background: none; border: none; cursor: pointer; font-size: 1.1rem;">
                                {{ $coupon->is_featured ? '⭐' : '☆' }}
                            </button>
                        </td>
                        <td>
                            <button type="button" wire:click="toggleActive({{ $coupon->id }})" style="background: none; border: none; cursor: pointer;">
                                @if($coupon->is_active)
                                    <span class="badge-status badge-success">Active</span>
                                @else
                                    <span class="badge-status badge-gray">Inactive</span>
                                @endif
                            </button>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" wire:click="openEditModal({{ $coupon->id }})" class="btn-admin" style="padding: 6px 12px; font-size: 0.82rem;">
                                    ✏️ Edit
                                </button>
                                <button type="button" wire:click="deleteCoupon({{ $coupon->id }})" wire:confirm="Are you sure you want to delete this coupon?" class="btn-admin btn-danger" style="padding: 6px 12px; font-size: 0.82rem;">
                                    🗑️ Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No coupons found. Click "Add New Coupon" to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $coupons->links() }}
        </div>
    </div>

    <!-- CREATE / EDIT MODAL -->
    @if($isFormOpen)
        <div class="admin-modal-overlay">
            <div class="admin-modal">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 1.3rem; font-weight: 800;">
                        {{ $editingCouponId ? 'Edit Coupon' : 'Create New Airline Coupon' }}
                    </h3>
                    <button type="button" wire:click="closeModal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
                </div>

                <form wire:submit.prevent="saveCoupon">
                    <div class="form-group">
                        <label class="form-label">Airline *</label>
                        <select wire:model="airline_id" class="form-input">
                            <option value="">Select Airline</option>
                            @foreach($airlines as $air)
                                <option value="{{ $air->id }}">{{ $air->name }}</option>
                            @endforeach
                        </select>
                        @error('airline_id') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select wire:model="coupon_category_id" class="form-input">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Offer Title *</label>
                        <input type="text" wire:model="title" class="form-input" placeholder="e.g. Exclusive $150 OFF USA Roundtrip Flights">
                        @error('title') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Coupon Code *</label>
                            <input type="text" wire:model="code" class="form-input" placeholder="e.g. DELTA150OFF">
                            @error('code') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Discount Badge Label *</label>
                            <input type="text" wire:model="discount_label" class="form-input" placeholder="e.g. $150 INSTANT OFF">
                            @error('discount_label') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea wire:model="description" class="form-input" rows="3" placeholder="Short offer detail..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Terms & Conditions</label>
                        <input type="text" wire:model="terms" class="form-input" placeholder="e.g. Phone booking required. Valid on roundtrip itineraries.">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Phone Number Override (Optional)</label>
                            <input type="text" wire:model="phone_number" class="form-input" placeholder="e.g. +1 (800) 555-0199">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" wire:model="expiry_date" class="form-input">
                        </div>
                    </div>

                    <div class="form-group" style="display: flex; gap: 24px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer;">
                            <input type="checkbox" wire:model="is_featured"> Featured Deal (Homepage Top Card)
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer;">
                            <input type="checkbox" wire:model="is_active"> Active Status
                        </label>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                        <button type="button" wire:click="closeModal" class="btn-admin" style="background: #e2e8f0; color: #334155;">Cancel</button>
                        <button type="submit" class="btn-admin">Save Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
