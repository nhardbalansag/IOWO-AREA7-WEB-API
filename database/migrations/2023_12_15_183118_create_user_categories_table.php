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
        Schema::create('user_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_category_title')->nullable(false);
            $table->string('user_category_description')->nullable(false);
            $table->string('status')->nullable(false)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_categories');
    }
};

// - id
// - leader title
// - leader title description
// - status
// - isdeleted
// - date_created
// - date_updated
