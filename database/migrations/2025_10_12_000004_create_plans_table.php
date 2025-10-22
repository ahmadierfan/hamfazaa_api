<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {

        Schema::create('b_plans', function (Blueprint $table) {
            $table->bigIncrements('pk_plan');
            $table->foreignId('fk_product')->constrained('m_products', 'pk_product');
            $table->string('plan');
            $table->string('subtitle');
            $table->integer('maxusers')->default(0);
            $table->integer('max_room')->default(0);
            $table->json('price')->nullable();
            $table->json('options')->nullable();
            $table->longText('icon')->nullable();
            $table->unsignedTinyInteger('seasonaldiscount')->default(0);
            $table->unsignedTinyInteger('annuallydiscount')->default(0);
            $table->boolean('istrial')->default(false);
            $table->boolean('isfree')->default(false);

            $table->timestamps();
        });

    }


    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
