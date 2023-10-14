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
        Schema::create("job_posts", function (Blueprint $table) {
            $table->id();
            $table->string("company_name");
            $table->string("title");
            $table->unsignedBigInteger("contract_type_id");
            $table->boolean("is_featured");
            $table->unsignedBigInteger("level_id");
            $table->unsignedBigInteger("location");
            $table->integer("salary");
            $table->string("logo");
            $table->unsignedBigInteger("author");
            $table->timestamps();

            $table->foreign("contract_type_id")->references("id")->on("contract_types")
                ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("level_id")->references("id")->on("levels")
                ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("location")->references("id")->on("countries")
                ->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("author")->references("id")->on("users")
                ->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};