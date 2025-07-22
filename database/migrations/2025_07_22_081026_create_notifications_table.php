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
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->string('recipient', 50);
        $table->string('priority', 20);
        $table->string('subject', 100);
        $table->text('message');
        $table->string('attachment', 100)->nullable();
        $table->string('status', 20);
        $table->dateTime('sent_at');

        
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
