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
    Schema::create('receipts', function (Blueprint $table) {
        $table->id();
        $table->string('supplier_name');
        $table->enum('product_source', ['Panel', 'Groceries']);
        $table->date('deliver_date');

        $table->string('photo_one');
        $table->string('photo_two');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
