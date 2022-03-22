<?php

namespace App\Providers;

use App\Contracts\XmlBookValidatorInterface;
use App\Contracts\XmlGameValidatorInterface;
use App\Contracts\XmlMovieValidatorInterface;
use App\Models\Book;
use App\Models\Game;
use App\Models\Movie;
use App\Validators\XmlBookValidator;
use App\Validators\XmlGameValidator;
use App\Validators\XmlMovieValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(XmlGameValidatorInterface::class, function () {
            return new XmlGameValidator(
                storage_path('data/schemas_xml/gameDefinition.xsd'),
                Game::class,
            );
        });

        $this->app->singleton(XmlMovieValidatorInterface::class, function () {
            return new XmlMovieValidator(
                storage_path('data/schemas_xml/movieDefinition.xsd'),
                Movie::class,
            );
        });

        $this->app->singleton(XmlBookValidatorInterface::class, function () {
            return new XmlBookValidator(
                storage_path('data/schemas_xml/bookDefinition.xsd'),
                Book::class,
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
