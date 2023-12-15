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
        Schema::create('user_role_accesses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('role_id')->unsigned()->nullable(false);
            $table->foreign('role_id')
            ->references('id')
            ->on('user_roles')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->bigInteger('access_type_id')->unsigned()->nullable(false);
            $table->foreign('access_type_id')
            ->references('id')
            ->on('access_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->boolean('isdeleted')->nullable(false)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_accesses');
    }
};

// USER ROLE ACCESS
// 	- id
// 	- user_id => USER
// 	- role_id => ROLES
// 	- access_type_id => ACCESS TYPE
// 	- isdeleted
// 	- date_created
// 	- date_updated
