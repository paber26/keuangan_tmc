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
        Schema::create('pemakaian_b_b_m_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemakaian_bbm_id')->constrained('pemakaian_bbm')->onDelete('cascade');
            $table->string('image_path');
            $table->string('original_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_b_b_m_images');
    }
};
