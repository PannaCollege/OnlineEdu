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
        Schema::create('course_entrollments', function (Blueprint $table) {
            $table->ulid('id');
            $table->foreignUlid('course_id');
            $table->foreignUlid('user_id');
            $table->dateTime('enrollment_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_entrollments');
    }
};
