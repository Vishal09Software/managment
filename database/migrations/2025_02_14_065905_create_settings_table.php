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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_phone');
            $table->string('business_email');
            $table->string('business_address');
            $table->string('gst_number');
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('ifsc_code');
            $table->string('account_holder_name');
            $table->string('business_logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
