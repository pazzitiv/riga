<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('left_team')->nullable(false);
            $table->foreign('left_team')
                ->references('id')
                ->on('commands');
            $table->bigInteger('right_team')->nullable(false);
            $table->foreign('right_team')
                ->references('id')
                ->on('commands');
            $table->integer('left_score')->nullable(false)->default(0);
            $table->integer('right_score')->nullable(false)->default(0);
            $table->integer('stage')->nullable(false);
            $table->boolean('release')->default(false);
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
        Schema::dropIfExists('games');
    }
}
