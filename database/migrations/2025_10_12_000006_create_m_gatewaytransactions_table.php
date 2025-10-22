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
        Schema::create('m_gatewaytransactions', function (Blueprint $table) {
            $table->bigIncrements('pk_gatewaytransaction');
            $table->foreignId('fk_registrar')->nullable()->constrained('users', 'id');
            $table->foreignId('fk_order')->nullable()->constrained('m_orders', 'pk_order');
            $table->foreignId('fk_paymentstatus')->constrained('b_paymentstatuses', 'pk_paymentstatus');
            $table->unsignedInteger('amount');
            $table->string('authority', 150)->nullable();
            $table->string('gateway', 50)->nullable();
            $table->string('refid', 100)->nullable();
            $table->string('token', 100)->nullable();
            $table->string('terminal', 40)->nullable();
            $table->timestamp('paidat')->nullable();
            $table->timestamps(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_gatewaytransactions');
    }
};
