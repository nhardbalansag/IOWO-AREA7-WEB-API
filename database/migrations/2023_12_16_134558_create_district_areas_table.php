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
        Schema::create('district_areas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('district_id')->unsigned()->nullable(false);
            $table->foreign('district_id')
            ->references('id')
            ->on('districts')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('area_id')->unsigned()->nullable(false);
            $table->foreign('area_id')
            ->references('id')
            ->on('areas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('district_areas');
    }
};



// DISTRICT AREAS
// 	- id
// 	- district_id => DISTRICT
// 	- area_id => AREA
// 	- status
// 	- isdeleted
// 	- date_created
// 	- date_updated
