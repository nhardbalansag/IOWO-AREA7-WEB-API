<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generated_documents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->date('date_generated')->nullable(false)->default(now());
            $table->boolean('is_recognized')->nullable(false)->default(false);
            $table->boolean('is_deleted')->nullable(false)->default(false);
            $table->string('file_location')->nullable(false);
            $table->string('file_name')->nullable(false);
            $table->string('file_type_category')->nullable(false)->default('church');
            $table->string('code')->nullable(false)->default(Hash::make(now()));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
