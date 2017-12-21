<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opf', function (Blueprint $table) {
            $table->unsignedMediumInteger('id');
            $table->string('short',10)->nullable()->commetn('Краткая форма ОПФ');
            $table->string('full')->comment('Полная форма ОПФ');

            $table->primary('id');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name')->comment('Наименование');
            $table->string('full_name')->comment('Полное наименование');
            $table->text('description')->nullable()->comment('Краткое описание');
            $table->string('address')->nullable()->comment('Адрес организации');
            $table->string('web')->nullable()->comment('Сайт');
            $table->string('email')->nullable()->comment('Электронная почта');
            $table->unsignedBigInteger('inn')->unique()->nullable()->comment('ИНН организации');
            $table->unsignedMediumInteger('opf_id')->unique()->nullable()->comment('Код ОКОПФ');
            $table->timestamps();
            $table->foreign('opf_id')->references('id')->on('opf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['opf_id']);
        });

        Schema::dropIfExists('opf');
        Schema::dropIfExists('companies');
    }
}
