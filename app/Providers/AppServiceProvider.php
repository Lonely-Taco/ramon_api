<?php

namespace App\Providers;

use App\Charts\BookChart;
use App\Charts\GameChart;
use App\Charts\MovieChart;
use App\Contracts\JsonBookValidatorInterface;
use App\Contracts\JsonGameValidatorInterface;
use App\Contracts\JsonMovieValidatorInterface;
use App\Contracts\JsonTagValidatorInterface;
use App\Contracts\XmlBookValidatorInterface;
use App\Contracts\XmlGameValidatorInterface;
use App\Contracts\XmlMovieValidatorInterface;
use App\Contracts\XmlTagValidatorInterface;
use App\Models\Book;
use App\Models\Game;
use App\Models\Movie;
use App\Models\Tag;
use App\Validators\JsonBookValidator;
use App\Validators\JsonGameValidator;
use App\Validators\JsonMovieValidator;
use App\Validators\JsonTagValidator;
use App\Validators\XmlBookValidator;
use App\Validators\XmlGameValidator;
use App\Validators\XmlMovieValidator;
use App\Validators\XmlTagValidator;
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
            GameChart::class,
            MovieChart::class,
            BookChart::class,
        ]);
    }

    protected function makeXmlValidators(): void
    {
        $this->app->singleton(XmlGameValidatorInterface::class, function () {
            return new XmlGameValidator(
                storage_path('data/schemas_xml/gameDefinition.xsd'),
                storage_path('data/schemas_xml/tagDefinition.xsd'),
                Game::class,
            );
        });

        $this->app->singleton(XmlMovieValidatorInterface::class, function () {
            return new XmlMovieValidator(
                storage_path('data/schemas_xml/movieDefinition.xsd'),
                storage_path('data/schemas_xml/tagDefinition.xsd'),
                Movie::class,
            );
        });

        $this->app->singleton(XmlBookValidatorInterface::class, function () {
            return new XmlBookValidator(
                storage_path('data/schemas_xml/bookDefinition.xsd'),
                storage_path('data/schemas_xml/tagDefinition.xsd'),
                Book::class,
            );
        });

        $this->app->singleton(XmlTagValidatorInterface::class, function () {
            return new XmlTagValidator(
                storage_path('data/schemas_xml/tagDefinition.xsd'),
                storage_path('data/schemas_xml/tagDefinition.xsd'),
                Tag::class,
            );
        });
    }

    protected function makeJsonValidators(): void
    {
        $this->app->singleton(JsonGameValidatorInterface::class, function () {
            return new JsonGameValidator(
                storage_path('data/schemas_json/game-schema.json'),
                storage_path('data/schemas_json/tag-schema.json'),
                Game::class,
            );
        });

        $this->app->singleton(JsonMovieValidatorInterface::class, function () {
            return new JsonMovieValidator (
                storage_path('data/schemas_json/movie-schema.json'),
                storage_path('data/schemas_json/tag-schema.json'),
                Movie::class,
            );
        });

        $this->app->singleton(JsonBookValidatorInterface::class, function () {
            return new JsonBookValidator(
                storage_path('data/schemas_json/book-schema.json'),
                storage_path('data/schemas_json/tag-schema.json'),
                Book::class,
            );
        });

        $this->app->singleton(JsonTagValidatorInterface::class, function () {
            return new JsonTagValidator(
                storage_path('data/schemas_json/tag-schema.json'),
                storage_path('data/schemas_json/tag-schema.json'),
                Tag::class,
            );
        });
    }
}
