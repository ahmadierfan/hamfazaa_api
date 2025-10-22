<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('m_orders', function (Blueprint $table) {
            $table->bigIncrements('pk_order');
            $table->foreignId('fk_registrar')->constrained('users', 'id');
            $table->foreignId('fk_user')->constrained('users', 'id');
            $table->foreignId('fk_product')->constrained('m_products', 'pk_product');
            $table->foreignId('fk_plan')->constrained('b_plans', 'pk_plan');
            $table->foreignId('fk_period')->constrained('b_periods', 'pk_period');
            $table->integer('maxusers');
            $table->decimal('totalprice', 12, 2)->default(0);
            $table->string('paymentmethod')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
