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
        Schema::create('ticket_status_history', function (Blueprint $table) {

            
            $table->unsignedBigInteger( 'ticket_id' )->nullable(false);
            $table->string( 'status', 10 )->nullable( false );
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_status_history');
    }
};
