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
        Schema::create('r_usergrouprooms', function (Blueprint $table) {
            $table->bigIncrements('pk_usergrouproom');
            $table->foreignId('fk_registrar')->constrained('users');
            $table->foreignId('fk_usergroup')->constrained('m_usergroups', 'pk_usergroup');
            $table->foreignId('fk_room')->constrained('m_rooms', 'pk_room');
            $table->integer('maxhoursperweek');
            $table->bigInteger('amountperhour')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_usergrouprooms');
    }
};
