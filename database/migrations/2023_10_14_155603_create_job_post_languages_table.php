<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_post_languages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('job_post_id')->constrained('job_posts')
                ->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_languages');
    }
};