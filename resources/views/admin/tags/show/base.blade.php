@extends('admin.base')

@section('content_header')
<div class="d-inline">{{ $tag->title }}</div>
@endsection

@section('content')

@include('admin.includes.messages.base')

<h5 class="text-muted">{{ $tag->slug }}</h6>

<div class="">
	<h5 class="d-inline"> Questions: {{ $tag->questions->count() }}</h5>
</div>

<ul class="nav nav-tabs mb-2">
	<li class="nav-item">
		<a href="{{ route('admin.tags.info', $tag->slug) }}" class="nav-link @yield('info')">
			Information
		</a>
	</li>
	<li class="nav-item">
		<a href="{{ route('admin.tags.questions', $tag->slug) }}" class="nav-link @yield('questions')">
			Questions
		</a>
	</li>
</ul>

@yield('tab_content')

@endsection

@section('right_panel')
	@component('admin.includes.right_panel_show')
		@slot('edit')
			{{ route('admin.tags.edit', $tag->slug) }}			
		@endslot

		@slot('destroy')
			{{ route('admin.tags.destroy', $tag->slug) }}
		@endslot
	@endcomponent
@endsection