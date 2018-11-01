@extends('layouts.app')

@section('content')

	<div class="col-md-12">	
		<h1 class="text-center">Create Article</h1>
		
		{!! Form::open(['method' => 'POST', 'action' => 'ArticleController@store']) !!}
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
			@foreach($tags as $tag)
                <div class="uk-form-row">
                    <div class="uk-form-controls uk-form-controls-text">
                        <input type="checkbox" value="{{ $tag->id }}" name="tag_id[]">
                        <label for="{{$tag->id}}">{{$tag->name}}</label>
                    </div>
                </div>
            @endforeach
		  </div>
		  @if($errors->has('tag_id'))
		    	{{$errors->first('tag_id')}}
		    @endif
		  {!! Form::submit('Create Article', ['class' => 'btn btn-primary', 'name' => 'submit']) !!}
		{!! Form::close() !!}
	</div>

@stop