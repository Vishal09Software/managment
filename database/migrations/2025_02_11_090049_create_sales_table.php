<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
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
            $table->string('r_weight'); //rawana weight
            $table->string('k_weight'); //kanta weight
            $table->string('product_id');
            $table->string('p_price'); //purchase price
            $table->string('s_price'); //sale price
            $table->string('tax_id')->index();
            $table->string('tax_name');
            $table->string('tax_rate');
            $table->string('remark');
            $table->string('p_total'); //purchase total
            $table->string('s_total'); //sale total
            $table->string('v_total'); //vehicle total
            $table->string('supply_place');
            $table->string('invoice_number');
            $table->softDeletes();
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
