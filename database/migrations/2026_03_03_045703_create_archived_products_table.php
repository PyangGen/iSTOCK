<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('archived_products', function (Blueprint $table) {
    $table->id();
    $table->string('pd_photo')->nullable();
    $table->string('pd_name');
    $table->string('pd_code')->nullable();
    $table->text('pd_desc')->nullable();
    $table->integer('pd_qty')->default(0);
    $table->string('pd_unit')->nullable();
    $table->decimal('pd_cost_price', 10, 2)->nullable();
    $table->decimal('pd_price', 10, 2);
    $table->unsignedBigInteger('category_id')->nullable();
    $table->string('pd_supplier')->nullable();
    $table->date('pd_expiry_date')->nullable();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_products');
    }
};
