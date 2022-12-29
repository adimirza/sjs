<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BsMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('parent')->nullable();
            $table->string('nama')->unique();
            $table->text('url');
            $table->text('uri')->nullable();
            $table->string('icon')->nullable();
            $table->integer('urutan');
            $table->integer('id_heading');
            $table->integer('status');
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
        Schema::dropIfExists('bs_menu');
    }
}
