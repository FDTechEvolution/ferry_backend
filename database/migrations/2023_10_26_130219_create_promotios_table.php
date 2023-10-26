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
        Schema::create('promotios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->tinyInteger('discount');
            $table->enum('discout_type', ['percent', 'thb']);
            $table->smallInteger('usage');
            $table->date('depart_start')->nullable();
            $table->date('depart_end')->nullable();
            $table->date('booking_start');
            $table->date('booking_end');
            $table->tinyInteger('age_min')->nullable();
            $table->tinyInteger('age_max')->nullable();
            $table->smallInteger('usage_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotios');
    }
};
