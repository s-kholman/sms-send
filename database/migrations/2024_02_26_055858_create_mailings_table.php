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
        Schema::create('mailings', function (Blueprint $table) {
            $table->id();
            $table->string('mailing_name',255);
            $table->string('mailing_text',255);
            $table->time('mailing_send_birth')->nullable()->default(null); //Рассылка день рождения
            $table->dateTime('mailing_immediate_dispatch')->nullable()->default(null); //Немедленная отправка
            $table->dateTime('mailing_deferred')->nullable()->default(null); //Отправка в определенную дату
            $table->dateTime('mailing_frequency_date')->nullable()->default(null); //Дата переодичных рассылок
            $table->integer('mailing_frequency_type')->nullable()->default(null); //Повтор переодичных рассылок
            $table->integer('mailing_type');
            $table->integer('mailing_to_day');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailings');
    }
};
