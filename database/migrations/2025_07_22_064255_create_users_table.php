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
            $table->id('id'); // Custom primary key name
            $table->string('email', 100)->unique();
            $table->enum('user_type', ['Partner', 'Staff', 'Admin', 'Customer']);
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign keys
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');
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
