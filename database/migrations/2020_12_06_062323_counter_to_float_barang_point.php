<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CounterToFloatBarangPoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->decimal('counter', 8, 3)->default(0.0)->change();
        });

        Schema::table('point_history', function (Blueprint $table) {
            $table->decimal('count', 8, 3)->default(0.0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->integer('counter')->default(0)->change();
        });

        Schema::table('point_history', function (Blueprint $table) {
            $table->integer('count')->default(0)->change();
        });
    }
}
