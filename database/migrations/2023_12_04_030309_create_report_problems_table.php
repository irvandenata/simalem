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
        Schema::create('report_problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('item_installeds')->onDelete('cascade');
            $table->text('description');
            $table->date('response_at')->nullable();
            $table->date('finished_at')->nullable();
            $table->tinyInteger('status')->comment('0: Dibuat, 1: Ditanggapi, 2: Selesai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_problems');
    }
};
