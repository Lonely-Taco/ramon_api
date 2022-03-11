<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Imports\BookImport;
use App\Imports\GameImport;
use App\Imports\MovieImport;
use App\Models\Book;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class InsertData extends Command
{
    protected $signature = 'insert:data';

    protected $description = 'inserts the data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        Excel::import(new BookImport, storage_path('data/books.csv'));
        $this->info('books inserted');

        Excel::import(new GameImport, storage_path('data/games.csv'));
        $this->info('games inserted');

        Excel::import(new MovieImport, storage_path('data/movies.csv'));
        $this->info('movies inserted');

        $this->getTags();
    }
}
