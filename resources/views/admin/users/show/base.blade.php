@extends('admin.base')

@section('content_header')
	<img class="large-icon" src="{{ asset('storage/'.$user->profile_image) }}" alt="Profile image">
	<div class="">{{ $user->profileName }}</div>
@endsection

@section('content')

<h5 class="text-muted">{{ $user->briefly_about_myself }}</h6>

	<div class="mb-2">
		<h5 class="d-inline"> Questions: {{ $user->questions_count }} |</h5>
		<h5 class="d-inline"> Answers: {{ $user->answers_count }} |</h5>
		<h5 class="d-inline"> Comments: {{ $user->comments_count }}</h5>
	</div>

	<ul class="nav nav-tabs mb-2">
		<li class="nav-item">
			<a href="{{ route('admin.users.info', $user->name) }}" class="nav-link @yield('info')">
				Information
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('admin.users.questions', $user->name) }}" class="nav-link @yield('questions')">
				Questions
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('admin.users.answers', $user->name) }}" class="nav-link @yield('answers')">
				Answers
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('admin.users.comments', $user->name) }}" class="nav-link @yield('comments')">
				Comments
			</a>
		</li>
	</ul>

@yield('tab_content')

@endsection

@section('right_sidebar')
	<li class="list-group-item">
	  <a class="btn btn-info" href="{{ route('admin.users.edit', $user->name) }}">Edit</a>
	</li>

	@admin
		<form action="{{ route('admin.users.destroy', $user->name) }}" method="POST">
			@method('DELETE')
			@csrf

			<li class="list-group-item">
			  <button type="submit" class="btn btn-danger">Delete user</button>
			</li>  	  
		</form>	
	@endadmin
	
@endsection
