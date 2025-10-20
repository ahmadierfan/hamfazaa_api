<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('b_plans', function (Blueprint $table) {
            $table->bigIncrements('pk_plan');
            $table->foreignId('fk_product')->constrained('users', 'id');
            $table->string('plan');
            $table->integer('duration_days')->comment('Number of days for the plan, e.g. 30,90,365,15');
            $table->decimal('price', 12, 2)->default(0);
            $table->boolean('is_istrial')->default(false);
            $table->boolean('is_free')->default(false);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
