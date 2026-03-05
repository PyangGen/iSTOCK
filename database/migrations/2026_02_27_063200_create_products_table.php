<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('pd_id');

            // Basic Info
            $table->string('pd_photo')->nullable();
            $table->string('pd_name', 150)->unique();
$table->string('pd_code', 100)->nullable()->unique();
$table->decimal('pd_price', 10, 2);

// optional fields
$table->text('pd_desc')->nullable();
$table->integer('pd_qty')->default(0);
$table->string('pd_unit')->default('pcs'); 
$table->decimal('pd_cost_price', 10, 2)->nullable();
$table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
$table->string('pd_supplier')->nullable();
$table->date('pd_expiry_date')->nullable();
$table->timestamp('pd_updateDate')->nullable();
$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};