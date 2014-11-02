@extends("master")

@section("title")
	List All the Books
@stop


@section("content")
	<h1>List of books</h1>
	
	<p>You searched for {{{ $query }}}</p>
	
	<p>Hello {{ $name}} </p>
	@foreach($books as $title => $book)
		<h3>{{ $title }}</h3>
		<p>{{$book['author'] }} ({{ $book['published'] }})</p>
	@endforeach
@stop
