<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->string('place_of_birth')->nullable();
            $table->string('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('sex')->nullable();
            $table->integer('point_total')->default(0);
            $table->timestamps();
        });

        Schema::create('point_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('warga_id')->index();
            $table->string('type');
            $table->text('description')->nullable();
            $table->integer('point')->default(0);
            $table->integer('point_total')->default(0);
            $table->string('verif_code')->nullable();
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('warga');
        Schema::dropIfExists('point_history');
    }
}
