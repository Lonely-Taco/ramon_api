@php /** @var \Illuminate\Support\Collection|\App\Models\Tag[] $tags */ @endphp

@extends('layout')
@section('content')
    <div id="chart" style="height: 500px;"></div>
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <!-- Your application script -->

    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "@chart('movie_chart')",
            hooks: new ChartisanHooks()
                .tooltip(true)
                .legend(),
        });
    </script>
    <div class="links">
        <a href="http://127.0.0.1:8000">
            Home
        </a>
        <a href="http://127.0.0.1:8000/games/chart/game-chart">
            Games
        </a>
        <a href="http://127.0.0.1:8000/movies/chart/movie-chart">
            Movies
        </a>
        <a href="http://127.0.0.1:8000/books/chart/book-chart">
            Books
        </a>
    </div>
    <div class="row m-16">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Movies</th>
                <th>Games</th>
                <th>Books</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>
                        {{ $tag->name }}
                    </td>
                    <td class="p-2">
                        {{ $tag->movies->count() }}
                    </td>
                    <td class="p-2">
                        {{ $tag->games->count() }}
                    </td>
                    <td class="p-2">
                        {{ $tag->books->count() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endsection
