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
        Schema::create('invoice_detail_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_import_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->string('invoice_number');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->unsignedBigInteger('branch_id');
            $table->string('branch_name');
            $table->unsignedBigInteger('customer_group_id');
            $table->string('customer_group_name');
            $table->unsignedBigInteger('seller_id');
            $table->string('seller_name');
            $table->unsignedBigInteger('quantity');
            $table->string('uom');
            $table->string('material_name');
            $table->unsignedBigInteger('category_l1_id');
            $table->string('category_l1_name');
            $table->decimal('total', 10, 2);
            $table->decimal('unit_price', 10, 2);
            $table->string('payment_method_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_detail_imports');
    }
};
