<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCompaniesTable extends Migration
{
    public function up()
    {
        DB::statement('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;');
        DB::statement('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;');
        DB::statement('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION";');


        Schema::create('m_companies', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_persian_ci';
            $table->bigIncrements('pk_company');
            $table->foreignId('fk_regsitrar')->nullable()->constrained('users', 'id');
            $table->string('company', 255)->charset('utf8mb4')->collation('utf8mb4_persian_ci');
            $table->string('isenable', 255)->default('1')->charset('utf8mb4')->collation('utf8mb4_persian_ci');
            $table->timestamps();

            $table->index('fk_regsitrar');
        });


    }

    public function down()
    {
        Schema::dropIfExists('m_companies');
    }
}
