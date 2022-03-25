<?php

namespace App\Providers;

use App\Contracts\JsonBookValidatorInterface;
use App\Contracts\JsonGameValidatorInterface;
use App\Contracts\JsonMovieValidatorInterface;
use App\Contracts\XmlBookValidatorInterface;
use App\Contracts\XmlGameValidatorInterface;
use App\Contracts\XmlMovieValidatorInterface;
use App\Models\Book;
use App\Models\Game;
use App\Models\Movie;
use App\Validators\JsonBookValidator;
use App\Validators\JsonGameValidator;
use App\Validators\JsonMovieValidator;
use App\Validators\XmlBookValidator;
use App\Validators\XmlGameValidator;
use App\Validators\XmlMovieValidator;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->makeJsonValidators();
        $this->makeXmlValidators();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\GameChart::class
        ]);
    }

    protected function makeXmlValidators(): void
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

    protected function makeJsonValidators(): void
    {
        $this->app->singleton(JsonGameValidatorInterface::class, function () {
            return new JsonGameValidator(
                storage_path('data/schemas_json/game-schema.json'),
                Game::class,
            );
        });

        $this->app->singleton(JsonMovieValidatorInterface::class, function () {
            return new JsonMovieValidator (
                storage_path('data/schemas_json/movie-schema.json'),
                Movie::class,
            );
        });

        $this->app->singleton(JsonBookValidatorInterface::class, function () {
            return new JsonBookValidator(
                storage_path('data/schemas_json/book-schema.json'),
                Book::class,
            );
        });
    }
}
