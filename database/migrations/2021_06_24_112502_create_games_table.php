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
            $table->string('name');
            $table->date('release_date');
            $table->text('categories');
            $table->text('genres');
            $table->text('steamspy_tags');
            $table->unsignedInteger('positive_ratings');
            $table->unsignedInteger('negative_ratings');
            $table->timestamps();
        });
    }
}
