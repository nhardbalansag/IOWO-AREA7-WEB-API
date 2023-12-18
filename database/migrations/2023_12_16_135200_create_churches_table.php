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
        Schema::create('churches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('district_area_id')->unsigned()->nullable(false);
            $table->foreign('district_area_id')
            ->references('id')
            ->on('district_areas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('church_name')->nullable(false);
            $table->string('church_address')->nullable(false);
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
        Schema::dropIfExists('churches');
    }
};

// CHURCH
// 	- id
// 	- church name
// 	- district description
// 	- district_area_id => DISTRICT AREAS
// 	- church_location_id => CHURCH LOCATION
// 	- isdeleted
// 	- date_created
// 	- date_updated
