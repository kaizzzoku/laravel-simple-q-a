@extends('public.base')

@section('content_header', 'Users')

@section('content')

	<div class="d-flex flex-wrap">
		@foreach($users as $user)
			@include('public.components.user_card')
		@endforeach		
	</div>

	{{ $users->links() }}
@endsection