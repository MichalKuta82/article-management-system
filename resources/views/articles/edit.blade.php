@extends('layouts.app')

@section('content')
	<div class="col-md-12">	
		<h1 class="text-center">Edit Article</h1>
		
		{!! Form::model($article, ['method' => 'PATCH', 'action' => ['ArticleController@update', $article->id]]) !!}
		  <div class="form-group {{$errors->has('title') ? 'has-error' : '' }}">
		    {!! Form::label('title', 'Title:', ['for' => 'title']) !!}
		    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Article Title', 'name' => 'title']) !!}
		    @if($errors->has('title'))
		    	{{$errors->first('title')}}
		    @endif
		  </div>
		  <div class="form-group {{$errors->has('summary') ? 'has-error' : '' }}">
		    {!! Form::label('summary', 'Summary:', ['for' => 'summary']) !!}
		    {!! Form::text('summary', null, ['class' => 'form-control', 'placeholder' => 'Article Summary', 'name' => 'summary']) !!}
		    @if($errors->has('summary'))
		    	{{$errors->first('summary')}}
		    @endif
		  </div>
		  <div class="form-group {{$errors->has('content') ? 'has-error' : '' }}">
		    {!! Form::label('content', 'Content:', ['for' => 'content']) !!}
		    {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Article Content', 'name' => 'content']) !!}
		    @if($errors->has('content'))
		    	{{$errors->first('content')}}
		    @endif
		  </div>
		  <div class="form-group {{$errors->has('tag_id') ? 'has-error' : '' }}">
			@php
				$tag_ids = $article->tags;
				$tags_id = [];
				foreach($tag_ids as $key => $value){
					$tags_id[] =  $value->pivot->tag_id;
				}
			@endphp
			@foreach($tags as $tag)
		    <div class="uk-form-row">
				<div class="uk-form-controls uk-form-controls-text">
				    <input type="checkbox" value="{{ $tag->id }}" name="tag_id[]" {{ in_array($tag->id,$tags_id) ? 'checked':'' }} />
				    <label for="{{$tag->id}}">{{$tag->name}}</label>
				</div>
		    </div>
       		@endforeach
		  </div>
		  @if($errors->has('tag_id'))
		    	{{$errors->first('tag_id')}}
		    @endif
		  <div>
		  	{!! Form::submit('Update Article', ['class' => 'btn btn-primary col-md-4', 'name' => 'submit']) !!}
		  </div>
		{!! Form::close() !!}

		{!! Form::open(['method' => 'DELETE', 'action' => ['ArticleController@destroy', $article->id]]) !!}
			{!! Form::submit('Delete Article', ['class' => 'btn btn-danger pull-right col-md-4', 'name' => 'submit']) !!}
		{!! Form::close() !!}

		@if($article->is_published == 1)
			<!--<form action="/posts" method="post">-->
			{!! Form::open(['method' => 'PATCH', 'action' => ['ArticleController@approve', $article->id]]) !!}
				<input type="hidden" name="is_published" value="0">
			  {!! Form::submit('Unpublish', ['class' => 'btn btn-success pull-right col-md-4', 'name' => 'submit']) !!}
			{!! Form::close() !!}
		@else
			{!! Form::open(['method' => 'PATCH', 'action' => ['ArticleController@approve', $article->id]]) !!}
				<input type="hidden" name="is_published" value="1">
			  {!! Form::submit('Publish', ['class' => 'btn btn-info pull-right col-md-4', 'name' => 'submit']) !!}
			{!! Form::close() !!}
	  	@endif
	</div>


@stop