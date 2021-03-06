@extends('public.users.show.base')

@section('head')
	<script src="{{ asset('js/like.js') }}" defer></script>
@endsection

@section('answers', 'active')

@section('tab_content')

	@if($answers->isNotEmpty())
		<h3>Answers:</h3>

		<ul class="cards-list">
			@foreach($answers as $answer)

				<h3 class="mt-3">
					<a href="{{ route('questions.show', $answer->question_id) }}">
						{{ $answer->question->title }}
					</a>
				</h3>

				@component('public.components.answer')
					@slot('answer', $answer)
					@slot('user', $user)		
				@endcomponent
				
			@endforeach
		</ul>
		{{ $answers->links() }}
	@else
		<h4>The user has no answers yet</h4>
	@endif
	
@endsection