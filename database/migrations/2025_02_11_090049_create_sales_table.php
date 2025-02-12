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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('vendor_id')->index();
            $table->string('vendor_name');
            $table->string('vendor_mobile');
            $table->string('customer_id')->index();
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('eway_bill_number');
            $table->string('vehicle_id')->index();
            $table->string('vehicle_number');
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('vehicle_rate');
            $table->string('image');
            $table->string('r_weight');
            $table->string('k_weight');
            $table->string('product_id');
            $table->string('p_price');
            $table->string('s_price');
            $table->string('tax_id')->index();
            $table->string('tax_name');
            $table->string('tax_rate');
            $table->string('remark');
            $table->string('p_total');
            $table->string('s_total');
            $table->string('v_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
