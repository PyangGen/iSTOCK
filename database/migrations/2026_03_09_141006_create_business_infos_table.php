<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('business_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('business_type', 150);
            $table->string('business_name', 150);
            $table->string('phone_country_code', 10)->nullable(); // PH, US, JP
            $table->string('phone_ist_code', 20)->nullable();     // +63, +1, +81
            $table->string('mobile_no', 30)->nullable();
            $table->string('country_name', 120)->nullable();
            
            $table->timestamps();

            $table->unique('admin_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_infos');
    }
};