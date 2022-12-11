<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('gbp')->default(0)->after('name');
            $table->integer('usd')->default(0)->after('name');
            $table->integer('eur')->default(0)->after('name');
            $table->string('default_bal')->default('usd');
            $table->integer('level')->default(0)->after('name');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

};