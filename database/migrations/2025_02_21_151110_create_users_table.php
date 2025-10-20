<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('fk_company')->nullable()->constrained('m_companies', 'pk_company');
            $table->foreignId('fk_registrar')->nullable()->constrained('users', );
            $table->string('name', 255)->nullable()->collation('utf8mb4_persian_ci');
            $table->string('lastname', 255)->nullable()->collation('utf8mb4_persian_ci');
            $table->string('nationalcode', 45)->nullable()->collation('utf8mb4_persian_ci')->unique();
            $table->date('birthday')->nullable();
            $table->string('mobile', 20)->nullable()->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('email', 45)->nullable()->unique();
            $table->string('image', 145)->nullable();
            $table->dateTime('lastlogin')->nullable();
            $table->string('password', 145)->nullable();
            $table->string('attachments', 255)->nullable();
            $table->string('descriptions', 255)->nullable();
            $table->string('notificationtoken', 255)->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->tinyInteger('isenable')->default(1);
            $table->tinyInteger('ismanager')->default(0);
            $table->timestamps(0);
        });
    }

    public function down()
    {
        if (Schema::hasTable('m_agencies')) {
            Schema::table('m_agencies', function (Blueprint $table) {
                if (Schema::hasColumn('m_agencies', 'fk_registrar')) {
                    $table->dropForeign(['fk_registrar']);
                }
            });
        }
        if (Schema::hasTable('m_companies')) {
            Schema::table('m_companies', function (Blueprint $table) {

                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('m_companies');
                if ($doctrineTable->hasForeignKey('m_companies_fk_regsitrar_foreign')) {
                    $table->dropForeign('m_companies_fk_regsitrar_foreign');
                }
            });
        }


        Schema::dropIfExists('users');
    }
}
