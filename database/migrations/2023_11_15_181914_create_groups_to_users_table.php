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
        Schema::create('groups_to_users', function (Blueprint $table) {
            
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('group_id')->nullable(false);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');

            $table->unique( ['user_id', 'group_id'] );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups_to_users');
    }
};
