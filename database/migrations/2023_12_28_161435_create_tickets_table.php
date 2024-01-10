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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string( 'short_description', 255 )->nullable(false);
            $table->text( 'long_description' )->nullable(false);

            $table->unsignedBigInteger( 'category_id' )->nullable(false);
            $table->unsignedBigInteger( 'issued_user_id' )->nullable( false );
            $table->unsignedBigInteger( 'current_working_user' )->nullable( true );

            $table->string( 'current_status', 10 )->nullable( false );

            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('issued_user_id')->references('id')->on('users');
            $table->foreign('current_working_user')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
