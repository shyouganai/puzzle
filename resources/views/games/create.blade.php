@extends('app')

@section('content')
    <div class="title m-b-md">
        Ширина и высота
    </div>

    <form action="{{ route('games.store') }}" method="POST" class="links m-b-md" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="number" name="rows" placeholder="Строки">
        <input type="number" name="cols" placeholder="Столбцы">
        <input type="submit" value="Играть">
    </form>
@endsection
