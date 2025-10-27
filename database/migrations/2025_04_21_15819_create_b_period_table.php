<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBPeriodTable extends Migration
{
    public function up()
    {
        Schema::create('b_periods', function (Blueprint $table) {
            $table->bigIncrements('pk_period');
            $table->string('period', 255)->charset('utf8mb4')->collation('utf8mb4_persian_ci');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('b_periods');
    }
}
