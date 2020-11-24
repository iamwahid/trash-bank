<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnWargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->string('rt')->nullable()->after('point_total');
            $table->boolean('is_koordinator')->default(false)->after('point_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropColumn(['rt', 'is_koordinator']);
        });
    }
}
