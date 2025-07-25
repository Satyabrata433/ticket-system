<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('id_prefix', 10);
            $table->string('ticket_status', 20);
            $table->boolean('allow_customer');
            $table->boolean('internal_notes');
            $table->integer('close_days')->default(0);
            $table->integer('attachment_size');
            $table->string('attachment_types', 100);
            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
