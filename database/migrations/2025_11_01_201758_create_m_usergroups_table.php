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
        Schema::create('m_usergroups', function (Blueprint $table) {
            $table->bigIncrements('pk_usergroup');
            $table->foreignId('fk_registrar')->constrained('users');
            $table->string('usergroup');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_usergroups');
    }
};
