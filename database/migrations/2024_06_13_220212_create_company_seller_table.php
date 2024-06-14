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
        Schema::create('company_seller', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('seller_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('goal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_seller');
    }
};
