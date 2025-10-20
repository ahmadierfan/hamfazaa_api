<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_rooms', function (Blueprint $table) {
            $table->bigIncrements('pk_room');
            $table->foreignId('fk_company')->nullable()->constrained('m_companies', 'pk_company');
            $table->foreignId('fk_registrar')->nullable()->constrained('users');
            $table->string('room');
            $table->integer('maxhoursperweek');
            $table->integer('capacity')->default(1);
            $table->time('starttime');
            $table->time('endtime');
            $table->json('availabledays');
            $table->integer('maxhoursperuser')->default(1);
            $table->bigInteger('amountperhour')->default(0);
            $table->text('description')->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_rooms');
    }
};
