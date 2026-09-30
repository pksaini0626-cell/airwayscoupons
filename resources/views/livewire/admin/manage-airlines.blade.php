<div>
    @if(session()->has('message'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
            {{ session('message') }}
        </div>
    @endif

    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
            <div style="flex: 1; max-width: 400px;">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-input" placeholder="Search airline name or code...">
            </div>

            <button type="button" wire:click="openCreateModal" class="btn-admin">
                ➕ Add New Airline
            </button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Airline Name</th>
                    <th>Code</th>
                    <th>Total Coupons</th>
                    <th>Popular</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($airlines as $air)
                    <tr>
                        <td>
                            <div style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                @if($air->logo)
                                    <img src="{{ $air->logo }}" alt="{{ $air->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span>✈️</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong style="color: #0f172a; font-size: 1rem;">{{ $air->name }}</strong>
                        </td>
                        <td>
                            <span style="font-family: monospace; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-weight: 700;">{{ $air->code ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge-status badge-success">{{ $air->coupons_count }} Coupons</span>
                        </td>
                        <td>
                            <button type="button" wire:click="togglePopular({{ $air->id }})" style="background: none; border: none; cursor: pointer; font-size: 1.1rem;">
                                {{ $air->is_popular ? '⭐ Popular' : '☆ Standard' }}
                            </button>
                        </td>
                        <td>
                            <button type="button" wire:click="toggleActive({{ $air->id }})" style="background: none; border: none; cursor: pointer;">
                                @if($air->is_active)
                                    <span class="badge-status badge-success">Active</span>
                                @else
                                    <span class="badge-status badge-gray">Inactive</span>
                                @endif
                            </button>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" wire:click="openEditModal({{ $air->id }})" class="btn-admin" style="padding: 6px 12px; font-size: 0.82rem;">
                                    ✏️ Edit
                                </button>
                                <button type="button" wire:click="deleteAirline({{ $air->id }})" wire:confirm="Are you sure you want to delete this airline?" class="btn-admin btn-danger" style="padding: 6px 12px; font-size: 0.82rem;">
                                    🗑️ Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">
                            No airlines found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $airlines->links() }}
        </div>
    </div>

    <!-- CREATE / EDIT MODAL -->
    @if($isFormOpen)
        <div class="admin-modal-overlay">
            <div class="admin-modal">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 1.3rem; font-weight: 800;">
                        {{ $editingAirlineId ? 'Edit Airline' : 'Add New Airline' }}
                    </h3>
                    <button type="button" wire:click="closeModal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
                </div>

                <form wire:submit.prevent="saveAirline">
                    <div class="form-group">
                        <label class="form-label">Airline Name *</label>
                        <input type="text" wire:model="name" class="form-input" placeholder="e.g. Delta Air Lines">
                        @error('name') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">IATA Code</label>
                            <input type="text" wire:model="code" class="form-input" placeholder="e.g. DL">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Logo URL / Image Link</label>
                            <input type="text" wire:model="logo" class="form-input" placeholder="https://example.com/logo.png">
                        </div>
                    </div>

                    <div class="form-group" style="display: flex; gap: 24px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer;">
                            <input type="checkbox" wire:model="is_popular"> Popular Airline (Showcase Pill)
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; cursor: pointer;">
                            <input type="checkbox" wire:model="is_active"> Active Status
                        </label>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                        <button type="button" wire:click="closeModal" class="btn-admin" style="background: #e2e8f0; color: #334155;">Cancel</button>
                        <button type="submit" class="btn-admin">Save Airline</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
