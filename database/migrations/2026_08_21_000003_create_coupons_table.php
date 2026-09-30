<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_category_id')->nullable()->constrained('coupon_categories')->onDelete('set null');
            $table->string('title');
            $table->string('code');
            $table->string('discount_label'); // e.g. "Save $150", "25% OFF", "$75 Off Roundtrip"
            $table->text('description')->nullable();
            $table->text('terms')->nullable();
            $table->string('phone_number')->nullable(); // agent hotline override if any
            $table->date('expiry_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('clicks_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
