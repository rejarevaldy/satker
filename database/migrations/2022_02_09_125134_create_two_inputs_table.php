<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwoInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('two_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_input_id')->onDelete('cascade')->nullable();
            $table->integer('volume_capaian')->nullable();
            $table->string('uraian')->nullable()->default(null);
            $table->string('nomor_dokumen')->nullable()->default(null);
            $table->timestampTz('tanggal')->nullable()->default(null);
            $table->string('file')->nullable()->default(null);
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('two_inputs');
    }
}
