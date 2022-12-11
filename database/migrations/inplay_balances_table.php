<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inplay_balances', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->string('user_id', 300);
            $table->string('secret', 500);
            $table->string('currency', 15);
            $table->integer('inplay_balance', 5000)->default(0);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inplay_balances');
    }
};