<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('m_products', function (Blueprint $table) {
            $table->bigIncrements('pk_product');
            $table->string('product');
            $table->string('productsec');
            $table->boolean('isenable')->default(true);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('m_products');
    }
};
