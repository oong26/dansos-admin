<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePenerimaanBansosToPenerimaanDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $from = 'penerimaan_bansos';
        $to = 'penerimaan_dana';
        Schema::rename($from, $to);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $from = 'penerimaan_dana';
        $to = 'penerimaan_bansos';
        Schema::rename($from, $to);
    }
}
