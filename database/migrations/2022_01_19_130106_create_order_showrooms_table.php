<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderShowroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_showrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("market_id");
            $table->string("user_fullname");
            $table->string("user_email");
            $table->string("user_tel");
            $table->string("user_ext");
            $table->string("user_address");
            $table->foreign("market_id")->references("id")->on("markets");
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
        Schema::dropIfExists('order_showrooms');
    }
}
