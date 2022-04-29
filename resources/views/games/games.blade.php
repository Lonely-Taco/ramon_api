@php /** @var \Illuminate\Support\Collection $game */ @endphp
@extends('layout')

@section('content')
    <table>
        <thead>
            <th>Name</th>
        </thead>
        <tbody>
        @foreach($games->data as $game)
            <tr>
                <td>{{$game->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
