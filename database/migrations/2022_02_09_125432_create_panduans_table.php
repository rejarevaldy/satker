<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panduans', function (Blueprint $table) {
            $table->id();
            $table->enum('nama', ['Cara Input Data', 'Panduan Pelaksanaan Anggaran', 'RKAKL' , 'Usulan Rencana Kerja']);
            $table->string('file')->nullable();
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
        Schema::dropIfExists('panduans');
    }
}
