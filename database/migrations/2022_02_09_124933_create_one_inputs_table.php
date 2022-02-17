<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOneInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('digit');
            $table->string('kd_kro');
            $table->string('kd_ro');
            $table->string('nama_ro');
            $table->integer('volume_target');
            $table->string('satuan');
            $table->integer('volume_jumlah')->nullable()->default(0);
            $table->float('rvo');
            $table->float('rvo_maksimal');
            $table->bigInteger('pagu');
            $table->bigInteger('rp');
            $table->float('capaian');
            $table->bigInteger('sisa');
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('one_inputs');
    }
}
