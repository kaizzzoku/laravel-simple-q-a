@extends('public.base')

@section('head')
	<script src="{{ asset('js/like.js') }}" defer></script>
	<script src="{{ asset('js/subscribe.js') }}" defer></script>
@endsection

@section('content_header')
	<h5 class="card-subtitle mb-2">
		@foreach($question->tags as $tag)
		-	<a class="d-inline text-info" href="{{ route('tags.questions', $tag->slug) }}">
				{{ $tag->title }}
			</a>
		@endforeach
	</h5>
	<div class="">
		<img class="small-icon" src="{{ asset('storage/'.$question->user->profile_image) }}" alt="Profile image">

		<a href="{{ route('users.info', $question->user->name) }}">{{ $question->user->profileName }}</a>
	</div>
	<h2>{{ $question->title }}</h2>
@endsection

@section('content')

	<div class="question">

		<div class="ml-2">
			{{ $question->description }}
		</div>

		<p class="card-subtitle mt-2 ml-2 text-muted">
			{{ $question->created_at }} | {{ $question->views_count }} views
		</p>

		@if(auth()->id() === $question->user_id)
			<div class="mr-1 d-inline">
			  <a class="btn btn-info" href="{{ route('questions.edit', $question->id) }}">Edit question</a>
			</div>
		@endif	
		@auth
			@component('public.components.subscribe_btn')
				@slot('item', $question)
				@slot('subscribe_uri',
					route('questions.subscribe', $question->id))
				@slot('unsubscribe_uri', 
					route('questions.unsubscribe', $question->id))
			@endcomponent
		@endauth
	
		@component('public.components.comments_tab')
			@slot('item', $question)
			@slot('send_comment_url', route('comments.storeForQuestion', $question->id))
		@endcomponent		

	</div>

	<ul class="answers-tab list-group list-group-flush">

		@if($question->solutions)

			<h3>Solutions</h3>

			@foreach($question->solutions as $answer)	
				@component('public.components.question.answer')

					@slot('answer', $answer)

					@if($question->user_id == auth()->id())
						@slot('add_field')
							<a href="{{ route('answers.changeStatus', $answer->id) }}" class="btn btn-success mr-2">
								Remove from solutions
							</a>
						@endslot	
					@endif

				@endcomponent	
			@endforeach
		@endif
	</ul>

	<ul class="answers-tab list-group list-group-flush">
		
		@if($question->notSolutions)
			<h3>Answers</h3>
			@foreach($question->notSolutions as $answer)
				@component('public.components.question.answer')
					@slot('answer', $answer)

					@if($question->user_id === auth()->id())
						@slot('add_field')
							<a href="{{ route('answers.changeStatus', $answer->id) }}" class="btn btn-success mr-2">
								Add to solutions
							</a>
						@endslot	
					@endif
					
				@endcomponent	
			@endforeach
		@endif

	</ul>

	@auth
		<h3 class="mt-2">Your answer</h3>
		<br>
		<form action="{{ route('answers.store', $question->id) }}" method="POST">
			@csrf
			<input type="hidden" name="question_id" value="{{ $question->id }}">

			<div class="form-group">
				<h5 for="body">{{ auth()->user()->profileName }}</h5>
			    <textarea class="form-control" name="body" id="body" rows="5" required></textarea>
			</div>

			<button class="btn btn-primary" type="submit">Send</button>
		</form>
	@endauth
	
@endsection

@section('right_sidebar')
	@isset($questions_toplist)
		@component('public.components.toplist')
			@slot('toplist', $questions_toplist)
			@slot('title', 'Interesting questions')
			@slot('component_path', 'public.components.mini_question_card')
		@endcomponent
	@endisset
@endsection