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
            $table->integer('created_by');
            $table->string('digit');
            $table->string('kd_kro');
            $table->string('kd_ro');
            $table->enum('bidang' , ['Umum', 'PPA I', 'PPA II', 'SKKI', 'PAPK', 'Admin']);
            $table->string('nama_ro');
            $table->string('capaian_ro')->nullable()->default(null);
            $table->integer('volume_target');
            $table->enum('satuan', ['Kegiatan', 'Dokumen' ,'Pegawai', 'Rekomendasi' ,'ISO', 'Satker' , 'Laporan' ,'KPPN' , '-' , 'Bulan Layanan']);
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
