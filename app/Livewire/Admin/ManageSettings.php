<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Component;

class ManageSettings extends Component
{
    public string $site_name = '';
    public string $agent_phone = '';
    public string $agent_phone_display = '';
    public string $header_announcement = '';
    public string $support_hours = '';
    public string $footer_disclaimer = '';

    public function mount()
    {
        $this->site_name = SiteSetting::getByKey('site_name', 'Airways Coupons');
        $this->agent_phone = SiteSetting::getByKey('agent_phone', '+1 (800) 555-0199');
        $this->agent_phone_display = SiteSetting::getByKey('agent_phone_display', '+1 (800) 555-0199');
        $this->header_announcement = SiteSetting::getByKey('header_announcement', '🇺🇸 USA Exclusive Unadvertised Phone Deals - Save Up to $150 per ticket!');
        $this->support_hours = SiteSetting::getByKey('support_hours', '24/7 Live Booking Support');
        $this->footer_disclaimer = SiteSetting::getByKey('footer_disclaimer', 'AirwaysCoupons is an independent travel voucher and phone assistance service.');
    }

    public function saveSettings()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'agent_phone' => 'required|string|max:100',
            'agent_phone_display' => 'required|string|max:100',
            'header_announcement' => 'nullable|string|max:500',
            'support_hours' => 'nullable|string|max:255',
            'footer_disclaimer' => 'nullable|string',
        ]);

        SiteSetting::setKey('site_name', $this->site_name);
        SiteSetting::setKey('agent_phone', $this->agent_phone);
        SiteSetting::setKey('agent_phone_display', $this->agent_phone_display);
        SiteSetting::setKey('header_announcement', $this->header_announcement);
        SiteSetting::setKey('support_hours', $this->support_hours);
        SiteSetting::setKey('footer_disclaimer', $this->footer_disclaimer);

        session()->flash('message', 'Site settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.manage-settings')
            ->layout('layouts.admin', ['title' => 'Site Settings']);
    }
}
