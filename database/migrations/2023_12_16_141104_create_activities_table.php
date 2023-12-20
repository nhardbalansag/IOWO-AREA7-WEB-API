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
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('activity_category_id')->unsigned()->nullable(false)->default(1);
            $table->foreign('activity_category_id')
            ->references('id')
            ->on('activity_categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->integer('adult_attendance_count')->nullable(false)->default(0);
            $table->integer('youth_attendance_count')->nullable(false)->default(0);
            $table->integer('children_attendance_count')->nullable(false)->default(0);

            $table->decimal('tithes')->nullable(false)->default(0);
            $table->decimal('total_tithes')->nullable(false)->default(0);
            $table->decimal('total_offering')->nullable(false)->default(0);
            $table->decimal('gospel_seed')->nullable(false)->default(0);
            $table->decimal('personal_tithes')->nullable(false)->default(0);

            $table->integer('new_bible_studies_count')->nullable(false)->default(0);
            $table->integer('existing_bible_studies_count')->nullable(false)->default(0);

            $table->integer('received_jesus_count')->nullable(false)->default(0);

            $table->integer('water_baptized_count')->nullable(false)->default(0);
            $table->integer('holy_spirit_baptized_count')->nullable(false)->default(0);

            $table->integer('children_dedication_count')->nullable(false)->default(0);
            $table->integer('healed_count')->nullable(false)->default(0);

            $table->string('testimonies_miracles_details')->nullable(true);
            $table->date('activity_date')->nullable(false)->default(now())->uniqid;
            $table->string('remarks')->nullable(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

