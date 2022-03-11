<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('book_tag', function (Blueprint $table) {
            $table->foreignId('book_id');
            $table->foreignId('tag_id');
            $table->timestamps();
        });
    }
}
