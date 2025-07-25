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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id('id');
            $table->string('company_name', 100);
            $table->string('company_email', 100);
            $table->string('company_phone', 15);
            $table->string('date_format', 20);
            $table->text('company_address');
            $table->string('admin_logo', 100)->nullable();
            $table->string('customer_portal_logo', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
