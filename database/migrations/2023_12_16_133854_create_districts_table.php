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
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('district_name')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('status')->nullable(false)->default('active');
            $table->boolean('isdeleted')->nullable(false)->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};

// DISTRICT
// 	- id
// 	- district name
// 	- district description
// 	- status
// 	- isdeleted
// 	- date_created
// 	- date_updated
