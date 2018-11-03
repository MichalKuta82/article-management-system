@extends('layouts.app')

@section('content')

@if(Session::has('comment'))
  <div class="alert alert-success text-center">{{session('comment')}}</div>
@endif

    <div class="col-md-12">
        <!-- Blog article -->

        <!-- Title, Owner, Creation Date-->
        <h1>{{$article->title}}</h1> by <a href="#">{{$article->user->name}}</a> <span class="glyphicon glyphicon-time"></span> Posted on {{$article->created_at ? $article->created_at->toDayDateTimeString() : 'No date'}}</p>
        <hr>
        <!-- Article Content -->
        <h4>Summary:</h4>
        <p class="lead">{{$article->summary}}</p>
        <hr>
        <h4>Content:</h4>
        <p class="lead">{{$article->content}}</p>
        <hr>
        <!-- Article Comments -->
        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
		{!! Form::open(['method' => 'article', 'action' => 'CommentController@store']) !!}
			<input type="hidden" name="article_id" value="{{$article->id}}">
		  <div class="form-group {{$errors->has('body') ? 'has-error' : '' }}">
		    {!! Form::label('body', 'Body:', ['for' => 'body']) !!}
		    {!! Form::textarea('body', null, ['class' => 'form-control', 'placeholder' => 'Comment', 'name' => 'body', 'rows' => 4]) !!}
		    @if($errors->has('body'))
		    	{{$errors->first('body')}}
		    @endif
		  </div>
		  {!! Form::submit('Submit Comment', ['class' => 'btn btn-primary', 'name' => 'submit']) !!}
		{!! Form::close() !!}
        </div>
        <hr>
        <h3>Artilce Comments</h3>
        <!-- Posted Comments -->
        @if($comments)
        @foreach($comments as $comment)
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                    <small>{{$comment->created_at ? $comment->created_at->toDayDateTimeString() : 'No date'}}</small>
                </h4>
                {{$comment->body}}
            </div>
        </div>
        @endforeach
        @endif
    </div>

@stop