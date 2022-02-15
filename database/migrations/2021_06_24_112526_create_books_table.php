<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('authors')->nullable();
            $table->text('categories')->nullable();
            $table->float('average_rating',8,3)->nullable();
            $table->integer('ratings_count')->nullable();
            $table->date('publication_date')->nullable();
            $table->timestamps();
        });
    }
}
