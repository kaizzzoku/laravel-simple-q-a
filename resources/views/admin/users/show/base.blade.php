@extends('admin.base')

@section('content_header')
<div class="d-inline">{{ $user->profileName }}</div>
@endsection

@section('content')

<h5 class="text-muted">{{ $user->briefly_about_myself }}</h6>

<div class="">
	<h5 class="d-inline"> Questions: {{ $user->questions()->count() }} |</h5>
	<h5 class="d-inline"> Answers: {{ $user->answers()->count() }}</h5>
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

@section('right_panel')
	@component('admin.includes.right_panel_show')
		@slot('edit')
			{{ route('admin.users.edit', $user->name) }}			
		@endslot

		@slot('destroy')
			{{ route('admin.users.destroy', $user->name) }}
		@endslot
	@endcomponent
@endsection
