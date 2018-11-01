@extends('layouts.app')

@section('content')

	<div class="col-md-12">
		
		<h1 class="text-center">Comments</h1>

		<table class="table table-striped">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Article Name</th>
		      <th scope="col">Body</th>
		      <th scope="col">Created At</th>
		      <th scope="col">Updated At</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@if($comments)
			  	@foreach($comments as $comment)
				    <tr>				      
				      <th scope="row">{{$comment->id}}</th>
				      <td><a href="{{route('articles.show', $comment->article->id)}}">{{$comment->article->title}}</a></td>
				      <td>{{str_limit($comment->body, 15)}}</td>
				      <td>{{$comment->created_at->toDayDateTimeString()}}</td>
				      <td>{{$comment->updated_at->toDayDateTimeString()}}</td>
				    </tr>
			  	@endforeach
		  	@endif
		  </tbody>
		</table>
		{{ $comments->links() }}
	</div>

@stop