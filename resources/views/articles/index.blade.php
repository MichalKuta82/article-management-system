@extends('layouts.app')

@section('content')

@if(Session::has('created_article'))
  <div class="alert alert-success text-center">{{session('created_article')}}</div>
@endif
@if(Session::has('updated_article'))
  <div class="alert alert-success text-center">{{session('updated_article')}}</div>
@endif
@if(Session::has('deleted_article'))
  <div class="alert alert-danger text-center">{{session('deleted_article')}}</div>
@endif

	<div class="col-md-12">
	
	<h1 class="text-center">Articles</h1>
	<a href="{{route('articles.create')}}" type="button" class="btn btn-primary">Add Article</a>

		<table class="table table-striped">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Id</th>
		      <th scope="col">Title</th>
		      <th scope="col">Owner</th>
		      <th scope="col">Summary</th>
		      <th scope="col">Content</th>
		      <th scope="col">Tags</th>
		      <th scope="col">Created At</th>
		      <th scope="col">Updated At</th>
		      <th scope="col">Comments</th>
		      <th scope="col">Published</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@if($articles)
			  	@foreach($articles as $article)
				    <tr>				      
				      <th scope="row">{{$article->id}}</th>
				      <td>{{$article->title}}</td>
				      <td>{{$article->user->name}}</td>
				      <td>{{$article->summary}}</td>
				      <td>{{str_limit($article->content, 15)}}</td>
				      <td>@if($article->tags)
				      @foreach($article->tags as $tag)
				      	{{$tag->name}}<br>
				      @endforeach
				      </td>@endif
				      <td>{{$article->created_at->toDayDateTimeString()}}</td>
				      <td>{{$article->updated_at->toDayDateTimeString()}}</td>
				      <td>
				      	@if(count($article->comments) > 0)
				      		<a href="{{route('articles.show', $article->id)}}">{{count($article->comments)}}</a>
				      	@else
				      		<p>No Comments</p>
				      	@endif
				      </td>
				      <td>
				    @if($article->is_published == 1)
						<!--<form action="/posts" method="post">-->
						{!! Form::open(['method' => 'PATCH', 'action' => ['ArticleController@approve', $article->id]]) !!}
							<input type="hidden" name="is_published" value="0">
						  {!! Form::submit('Unpublish', ['class' => 'btn btn-success btn-sm', 'name' => 'submit']) !!}
						  <!--<button type="submit" name="submit" class="btn btn-primary">Create</button>-->
						{!! Form::close() !!}
					@else
						<!--<form action="/posts" method="post">-->
						{!! Form::open(['method' => 'PATCH', 'action' => ['ArticleController@approve', $article->id]]) !!}
							<input type="hidden" name="is_published" value="1">
						  {!! Form::submit('Publish', ['class' => 'btn btn-info btn-sm', 'name' => 'submit']) !!}
						  <!--<button type="submit" name="submit" class="btn btn-primary">Create</button>-->
						{!! Form::close() !!}
				  	@endif
				      </td>
				      <td><a href="{{route('articles.edit', $article->id)}}" type="button" class="btn btn-primary btn-sm">Edit</a></td>
				      <td>
				      	{!! Form::open(['method' => 'DELETE', 'action' => ['ArticleController@destroy', $article->id]]) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm', 'name' => 'submit']) !!}
						  <!--<button type="submit" name="submit" class="btn btn-primary">Create</button>-->
						{!! Form::close() !!}
					</td>
					<td>
						@if($article->is_published == 1)
							<a type="button" href="{{route('articles.show', $article->id)}}" class="btn btn-warning btn-sm">View Article</a>
						@else
							<p class="text-center">Publish the aricle to view its comments</p>
						@endif	
						</td>
				    </tr>
			  	@endforeach
		  	@endif
		  </tbody>
		</table>
		{{ $articles->links() }}
	</div>
@stop