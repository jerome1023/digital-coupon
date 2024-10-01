<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_coupon_stamps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_coupon_id')->constraint('user_coupons');
            $table->uuid('coupon_reward_id')->constraint('coupon_rewards');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coupon_stamps');
    }
};
