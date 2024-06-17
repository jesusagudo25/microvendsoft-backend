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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->date('date');
            $table->foreignId('user_id')->constrained()
                ->nullable()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()
                ->nullable()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('seller_id')->constrained()
                ->nullable()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->enum('status', [ 'paid', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
