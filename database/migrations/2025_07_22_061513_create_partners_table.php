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
        Schema::create('partners', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY
            $table->string('business_name', 100);
            $table->string('email', 100)->unique();
            $table->text('address');
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('status', 20);
            $table->string('contact_person_name', 100);
            $table->string('contact_person_mobile', 15);
            $table->timestamps();
        });

        // ✅ Add CHECK constraint after table creation
        DB::statement("ALTER TABLE partners ADD CONSTRAINT chk_partner_status CHECK (status IN ('Active', 'Inactive'))");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
