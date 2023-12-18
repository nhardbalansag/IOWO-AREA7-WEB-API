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
        Schema::create('assigned_church_leaders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('church_id')->unsigned()->nullable(false);
            $table->foreign('church_id')
            ->references('id')
            ->on('churches')
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
        Schema::dropIfExists('assigned_church_leaders');
    }
};

// ASSIGNED CHURCH LEADER
// 	- id
// 	- user_id => USER
// 	- church_id => CHURCH
// 	- status
// 	- isdeleted
// 	- date_created
// 	- date_updated
