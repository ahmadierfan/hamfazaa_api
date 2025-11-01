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
        Schema::create('r_userusergroups', function (Blueprint $table) {
            $table->bigIncrements('pk_userusergroup');
            $table->foreignId('fk_registrar')->constrained('users');
            $table->foreignId('fk_user')->constrained('users');
            $table->foreignId('fk_usergroup')->constrained('m_usergroups', 'pk_usergroup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_userusergroups');
    }
};
