<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('user_profile')->default('user.png');
            $table->string('nip');
            $table->string('nomor_telepon')->nullable();
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->enum('role' , ['Monitoring', 'Satker']);
            $table->string('password');
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
