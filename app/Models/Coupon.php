<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'coupon_category_id',
        'title',
        'code',
        'discount_label',
        'description',
        'terms',
        'phone_number',
        'expiry_date',
        'is_featured',
        'is_active',
        'clicks_count',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'clicks_count' => 'integer',
    ];

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CouponCategory::class, 'coupon_category_id');
    }
}
