@extends('layout')
@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                {{ config('app.name') }}
            </div>

            <div class="links">
                <a href="http://127.0.0.1:8000/api/documentation">
                    API Documentation
                </a>
                <a href="{{route('games.game-chart')}}">
                    Games
                </a>
                <a href="{{route('movies.movie-chart')}}">
                    Movies
                </a>
                <a href="{{ route('books.book-chart') }}">
                    Books
                </a>
                <a href="{{ route('all-chart') }}">
                    All
                </a>
            </div>

            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
    </div>
@endsection

