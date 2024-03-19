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
        Schema::create('sms_status_sends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mailing_id');
            $table->uuid('sms_send_id');
            $table->string('phone_send');
            $table->date('date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;
            $table->string('sms_status_code')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_status_sends');
    }
};
