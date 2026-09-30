<?php

namespace App\Livewire\Admin;

use App\Models\Airline;
use App\Models\Coupon;
use App\Models\CouponCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ManageCoupons extends Component
{
    use WithPagination;

    public string $search = '';
    public string $airlineFilter = '';
    public bool $isFormOpen = false;

    // Form fields
    public ?int $editingCouponId = null;
    public ?int $airline_id = null;
    public ?int $coupon_category_id = null;
    public string $title = '';
    public string $code = '';
    public string $discount_label = '';
    public string $description = '';
    public string $terms = '';
    public string $phone_number = '';
    public ?string $expiry_date = null;
    public bool $is_featured = false;
    public bool $is_active = true;

    protected function rules()
    {
        return [
            'airline_id' => 'required|exists:airlines,id',
            'coupon_category_id' => 'nullable|exists:coupon_categories,id',
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'discount_label' => 'required|string|max:100',
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'phone_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAirlineFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isFormOpen = true;
    }

    public function openEditModal($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->editingCouponId = $coupon->id;
        $this->airline_id = $coupon->airline_id;
        $this->coupon_category_id = $coupon->coupon_category_id;
        $this->title = $coupon->title;
        $this->code = $coupon->code;
        $this->discount_label = $coupon->discount_label;
        $this->description = $coupon->description ?? '';
        $this->terms = $coupon->terms ?? '';
        $this->phone_number = $coupon->phone_number ?? '';
        $this->expiry_date = $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : null;
        $this->is_featured = (bool) $coupon->is_featured;
        $this->is_active = (bool) $coupon->is_active;

        $this->isFormOpen = true;
    }

    public function closeModal()
    {
        $this->isFormOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingCouponId = null;
        $this->airline_id = null;
        $this->coupon_category_id = null;
        $this->title = '';
        $this->code = '';
        $this->discount_label = '';
        $this->description = '';
        $this->terms = '';
        $this->phone_number = '';
        $this->expiry_date = null;
        $this->is_featured = false;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function saveCoupon()
    {
        $this->validate();

        $data = [
            'airline_id' => $this->airline_id,
            'coupon_category_id' => $this->coupon_category_id,
            'title' => $this->title,
            'code' => strtoupper(trim($this->code)),
            'discount_label' => $this->discount_label,
            'description' => $this->description,
            'terms' => $this->terms,
            'phone_number' => $this->phone_number,
            'expiry_date' => $this->expiry_date,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->editingCouponId) {
            Coupon::findOrFail($this->editingCouponId)->update($data);
            session()->flash('message', 'Coupon updated successfully!');
        } else {
            Coupon::create($data);
            session()->flash('message', 'New coupon created successfully!');
        }

        $this->closeModal();
    }

    public function toggleActive($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();
    }

    public function toggleFeatured($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_featured = !$coupon->is_featured;
        $coupon->save();
    }

    public function deleteCoupon($id)
    {
        Coupon::findOrFail($id)->delete();
        session()->flash('message', 'Coupon deleted successfully.');
    }

    public function render()
    {
        $query = Coupon::with(['airline', 'category']);

        if (!empty($this->search)) {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
                  ->orWhere('discount_label', 'like', "%{$s}%");
            });
        }

        if (!empty($this->airlineFilter)) {
            $query->where('airline_id', $this->airlineFilter);
        }

        $coupons = $query->latest()->paginate(10);
        $airlines = Airline::orderBy('name')->get();
        $categories = CouponCategory::orderBy('name')->get();

        return view('livewire.admin.manage-coupons', compact('coupons', 'airlines', 'categories'))
            ->layout('layouts.admin', ['title' => 'Manage Coupons']);
    }
}
