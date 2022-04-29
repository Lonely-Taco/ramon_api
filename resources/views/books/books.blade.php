@php /** @var \Illuminate\Support\Collection $books */ @endphp
@extends('layout')

@section('content')
    <table>
        <thead>
        <th>Name</th>
        </thead>
        <tbody>
        @foreach($books->data as $book)
            <tr>
                <td>{{$book->title}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
