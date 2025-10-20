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
        Schema::create('s_bells', function (Blueprint $table) {
            $table->bigIncrements('pk_userlogin');
            $table->foreignId('fk_user')->nullable()->constrained('users');
            $table->foreignId('fk_company')->nullable()->constrained('m_companies', 'pk_company');
            $table->string('title', 255)->nullable();
            $table->string('message', 255)->nullable();
            $table->boolean('isseen')->nullable();
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_bells');
    }
};
