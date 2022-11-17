<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKandidatOsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kandidat_osis', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('paslon_no', false)->unique();
            $table->foreignId('ketua')->unique()->constrained('users');
            $table->foreignId('wakil')->unique()->constrained('users');
            $table->string('gambar');
            $table->text('visi');
            $table->text('misi');
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
        Schema::dropIfExists('kandidat_osis');
    }
}
