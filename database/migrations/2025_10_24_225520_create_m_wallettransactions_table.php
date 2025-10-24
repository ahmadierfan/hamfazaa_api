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
        Schema::create('m_wallettransactions', function (Blueprint $table) {
            $table->bigIncrements('pk_wallettransaction');
            $table->foreignId('fk_registrar')->nullable()->constrained('users');
            $table->foreignId('fk_user')->constrained('users');
            $table->foreignId('fk_confirmer')->constrained('users');
            $table->bigInteger('amount');
            $table->string('attachment', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->dateTime('confirmdatetime')->nullable();
            $table->tinyInteger('ispayed');
            $table->tinyInteger('isenable')->default(1);
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_wallettransactions');
    }
};
