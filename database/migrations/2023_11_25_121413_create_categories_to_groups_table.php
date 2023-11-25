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
        Schema::create('categories_to_groups', function (Blueprint $table) {
            
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->unsignedBigInteger('group_id')->nullable(false);

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('group_id')->references('id')->on('groups');

            $table->unique( ['category_id', 'group_id'] );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_to_groups');
    }
};
