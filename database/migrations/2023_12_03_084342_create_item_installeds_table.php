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
        Schema::create('item_installeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('serial_number');
            $table->string('hospital');
            $table->string('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->date('date_installed');
            $table->date('warranty_date');
            $table->date('maintenance_date_first');
            $table->text('maintenance_description_first')->nullable();
            $table->date('maintenance_created_at_first')->nullable();
            $table->date('maintenance_updated_at_first')->nullable();
            $table->date('maintenance_date_second');
            $table->text('maintenance_description_second')->nullable();
            $table->date('maintenance_created_at_second')->nullable();
            $table->date('maintenance_updated_at_second')->nullable();
            $table->date('maintenance_date_third');
            $table->text('maintenance_description_third')->nullable();
            $table->date('maintenance_created_at_third')->nullable();
            $table->date('maintenance_updated_at_third')->nullable();
            $table->string('unique_code')->nullable();
            $table->tinyInteger('status')->comment('0: Baik, 1: Rusak, 2: Perbaikan, 3: Berkendala');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_installeds');
    }
};
