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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_category_id')->unsigned()->nullable(false);
            $table->foreign('user_category_id')
            ->references('id')
            ->on('user_categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('firstname')->nullable(false);
            $table->string('lastname')->nullable(false);
            $table->string('middlename')->nullable(false);
            $table->date('birthday')->nullable(true);
            $table->string('address')->nullable(false);
            $table->string('contactnumber')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('isdeleted')->nullable(false)->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

// USER
// 	- id
// 	- user_category_id => USER CATEGORY
// 	- firstname
// 	- lastname
// 	- middlename
// 	- birthday
// 	- address
// 	- contactnumber
// 	- isdeleted
// 	- date_created
// 	- date_updated
