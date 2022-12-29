<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BsProfilWeb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_profil_web', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('logo')->nullable();
            $table->string('versi')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('bs_profil_web');
    }
}
