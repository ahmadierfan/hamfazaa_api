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
        Schema::create('s_userlogins', function (Blueprint $table) {
            $table->bigIncrements('pk_userlogin');
            $table->foreignId('fk_user')->nullable()->constrained('users');
            $table->string('logintype', 255);
            $table->string('failreason', 255)->nullable();
            $table->string('ipaddress', 45)->nullable();
            $table->string('device', 255)->nullable();
            $table->string('domain', 255)->nullable();
            $table->boolean('issuccess')->nullable();
            $table->timestamps(0);

            $table->index('fk_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_userlogins');
    }
};
