<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {


    public function up(): void
    {
        Schema::create('m_subscriptions', function (Blueprint $table) {
            $table->bigIncrements(column: 'pk_subscription');
            $table->foreignId('fk_company')->constrained('m_companies', 'pk_company');
            $table->foreignId('fk_product')->constrained('m_products', 'pk_product');
            $table->foreignId('fk_plan')->constrained('b_plans', 'pk_plan');
            $table->date('startdate');
            $table->date('enddate');
            $table->integer('maxusers')->nullable();
            $table->integer('currentusers')->default(0);
            $table->timestamps();
        });

        DB::statement('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;');
        DB::statement('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;');
        DB::statement('SET SQL_MODE=@OLD_SQL_MODE;');
    }

    public function down(): void
    {
        Schema::dropIfExists('m_subscriptions');
    }
};
