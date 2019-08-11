@extends('admin.base')



@section('content_header', 'Tag edit')

@section('content')

@include('admin.includes.messages.base')

<form method="post" action="{{ route('admin.tags.update', $tag->slug) }}">
	@method('PATCH')
	@csrf

	<div class="form-group">
		<label for="title">Title</label>

		<input class="form-control 
		@error('title') is_invalid @enderror"
		type="text" name="title"
		id="title" 
		value="{{ $tag->title }}">

		@error('title')
			<div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="slug">Slug</label>

		<input class="form-control 
		@error('slug') is_invalid @enderror"
		type="text" name="slug"
		id="slug" 
		value="{{ $tag->slug }}">

		@error('slug')
			<div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="description">Description</label>

		<textarea class="form-control @error('description') is_invalid @enderror"
		name="description" id="description" cols="30" rows="10"
		>{{ old('description', $tag->description) }}</textarea>

		@error('description')
			<div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>
	<button type="submit" class="btn btn-success">Update</button>
</form>

@endsection

@section('right_panel')
	@component('admin.includes.right_panel_edit')
		@slot('show')
			{{ route('admin.tags.info', $tag->slug) }}			
		@endslot

		@slot('destroy')
			{{ route('admin.tags.destroy', $tag->slug) }}
		@endslot
	@endcomponent
@endsection
