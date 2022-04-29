@php /** @var \Illuminate\Support\Collection $game */ @endphp
@extends('layout')

@section('content')
    <table>
        <thead>
            <th>Name</th>
        </thead>
        <tbody>
            <tr>
                <td>{{$game->name}}</td>
            </tr>
        </tbody>
    </table>
@endsection
