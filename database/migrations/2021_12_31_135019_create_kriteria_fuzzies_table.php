<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriaFuzziesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria_fuzzies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kriteria');
            $table->double('fuzzy_num_a');
            $table->double('fuzzy_num_b');
            $table->double('fuzzy_num_c');
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
        Schema::dropIfExists('kriteria_fuzzies');
    }
}
