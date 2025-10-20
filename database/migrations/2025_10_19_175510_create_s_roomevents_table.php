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
        Schema::create('s_roomevents', function (Blueprint $table) {
            $table->bigIncrements('pk_roomevent');
            $table->foreignId('fk_registrar')->constrained('users', 'id');
            $table->foreignId('fk_user')->constrained('users', 'id');
            $table->foreignId('fk_room')->constrained('m_rooms', 'pk_room');
            $table->foreignId('fk_gatewaytransaction')->nullable()->constrained('users', 'id');
            $table->datetime('startdatetime');
            $table->datetime('enddatetime');

            $table->timestamps(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_roomevents');
    }
};
