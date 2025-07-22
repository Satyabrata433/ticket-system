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
        Schema::create('login_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('partner_login');
            $table->boolean('customer_login');
            $table->boolean('employee_login');
            $table->boolean('admin_login');
            $table->boolean('password_reset');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_settings');
    }
};
