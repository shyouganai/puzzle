@extends('app')

@section('content')
    <div class="title m-b-md">
        Puzzle
    </div>

    <div class="links">
        <a href="{{ route('games.create') }}">Играть</a>
        <a href="https://laracasts.com">Как играть</a>
    </div>
@endsection
