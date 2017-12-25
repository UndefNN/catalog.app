<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->comment('ID компании');
            $table->unsignedBigInteger('number')->comment('Номер телефона');
            $table->string('desc')->comment('Краткое описание номера телефон');
            $table->enum('type', ['m', 'w', 'f'])->comment('Тип телефона: мобильный, рабочий, факс');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
