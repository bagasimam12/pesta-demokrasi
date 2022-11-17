<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKandidatMpkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kandidat_mpk', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('kandidat_no', false);
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->enum('type', ['wakil','ketua']);
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
        Schema::dropIfExists('kandidat_mpk');
    }
}
