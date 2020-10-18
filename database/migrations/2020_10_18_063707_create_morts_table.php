<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morts', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('qty');
            $table->integer('price');
            $table->unsignedBigInteger('bill_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('bill_id')->references('id')->on('bills');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('morts');
    }
}
