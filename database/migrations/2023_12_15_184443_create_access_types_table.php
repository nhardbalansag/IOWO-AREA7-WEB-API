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
        Schema::create('access_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('access')->nullable(false);
            $table->string('description')->nullable(false);
            $table->boolean('isdeleted')->nullable(false)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_types');
    }
};
// ACCESS TYPE
// 	- id
// 	- access
// 	- description
// 	- isdeleted
// 	- date_created
// 	- date_updated
