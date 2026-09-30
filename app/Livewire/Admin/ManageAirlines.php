<?php

namespace App\Livewire\Admin;

use App\Models\Airline;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ManageAirlines extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $isFormOpen = false;

    public ?int $editingAirlineId = null;
    public string $name = '';
    public string $code = '';
    public string $logo = '';
    public bool $is_popular = false;
    public bool $is_active = true;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'logo' => 'nullable|string|max:500',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isFormOpen = true;
    }

    public function openEditModal($id)
    {
        $airline = Airline::findOrFail($id);
        $this->editingAirlineId = $airline->id;
        $this->name = $airline->name;
        $this->code = $airline->code ?? '';
        $this->logo = $airline->logo ?? '';
        $this->is_popular = (bool) $airline->is_popular;
        $this->is_active = (bool) $airline->is_active;

        $this->isFormOpen = true;
    }

    public function closeModal()
    {
        $this->isFormOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingAirlineId = null;
        $this->name = '';
        $this->code = '';
        $this->logo = '';
        $this->is_popular = false;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function saveAirline()
    {
        $this->validate();

        $slug = Str::slug($this->name);

        $data = [
            'name' => $this->name,
            'slug' => $slug,
            'code' => strtoupper(trim($this->code)),
            'logo' => $this->logo,
            'is_popular' => $this->is_popular,
            'is_active' => $this->is_active,
        ];

        if ($this->editingAirlineId) {
            Airline::findOrFail($this->editingAirlineId)->update($data);
            session()->flash('message', 'Airline updated successfully!');
        } else {
            Airline::create($data);
            session()->flash('message', 'New airline added successfully!');
        }

        $this->closeModal();
    }

    public function toggleActive($id)
    {
        $airline = Airline::findOrFail($id);
        $airline->is_active = !$airline->is_active;
        $airline->save();
    }

    public function togglePopular($id)
    {
        $airline = Airline::findOrFail($id);
        $airline->is_popular = !$airline->is_popular;
        $airline->save();
    }

    public function deleteAirline($id)
    {
        Airline::findOrFail($id)->delete();
        session()->flash('message', 'Airline deleted successfully.');
    }

    public function render()
    {
        $query = Airline::withCount('coupons');

        if (!empty($this->search)) {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%");
            });
        }

        $airlines = $query->orderBy('name')->paginate(10);

        return view('livewire.admin.manage-airlines', compact('airlines'))
            ->layout('layouts.admin', ['title' => 'Manage Airlines']);
    }
}
