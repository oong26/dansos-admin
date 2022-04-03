<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBansosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_bansos', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->date('tanggal');
            $table->string('nominal', 10);
            $table->tinyInteger('status',false, true)
                ->default('1')
                ->comment('1=Sedang dalam proses, 2=Terkirim');
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('masyarakat')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaan_bansos');
    }
}
