@extends('admin.base')

@section('content_header')
<h5 class="card-subtitle mb-2">
	@foreach($question->tags as $tag)
	|	<a class="d-inline text-info" href="{{ route('admin.tags.questions', $tag->slug) }}">
			{{ $tag->title }}
		</a>
	@endforeach
</h5>
<h2>{{ $question->title }}</h2>
@endsection

@section('content')

<div class="question">
	<div class="ml-2">
		{{ $question->description }}
	</div>
	<p class="card-subtitle mt-2 ml-2 text-muted">{{ $question->created_at }}</p>

	@component('admin.includes.comments_tab')
		@slot('item', $question)
		@slot('form')
			@component('admin.includes.question_comment')
				@slot('id', $question->id)
			@endcomponent
		@endslot
	@endcomponent

</div>

<ul class="answers-tab list-group list-group-flush">

	@if(!empty($question->solutions))

		<h3>Solutions</h3>

		@foreach($question->solutions as $answer)	
			@component('admin.includes.answer')
				@slot('user', $answer->user)
				@slot('answer', $answer)
				
				@if($question->id == auth()->id() || true)
					@slot('add_field')
						<a href="{{ route('admin.answers.change_status', $answer->id) }}" class="btn btn-success mr-2">
							Remove from solutions
						</a>
					@endslot	
				@endif

				@slot('comments')
					@component('admin.includes.comments_tab')
						@slot('item', $answer)
						
						@slot('form')
							@component('admin.includes.answer_comment')
								@slot('id', $answer->id)
							@endcomponent
						@endslot	
					@endcomponent
				@endslot
			@endcomponent	
		@endforeach
	@endif
</ul>

<ul class="answers-tab list-group list-group-flush">
	
	@if(!empty($question->notSolutions))
		<h3>Answers</h3>
		@foreach($question->notSolutions as $answer)
			@component('admin.includes.answer')
				@slot('answer', $answer)
				@slot('user', $answer->user)

				@if($question->id == auth()->id() || true)
					@slot('add_field')
						<a href="{{ route('admin.answers.change_status', $answer->id) }}" class="btn btn-success mr-2">
							Add to solutions
						</a>
					@endslot	
				@endif

				@slot('comments')
					@component('admin.includes.comments_tab')
						@slot('item', $answer)

						@slot('form')
							@component('admin.includes.answer_comment')
								@slot('id', $answer->id)
							@endcomponent
						@endslot
					@endcomponent
				@endslot

			@endcomponent	
		@endforeach
	@endif
</ul>

<h3 class="mt-2">Your answer</h3>
<br>
<form action="{{ route('admin.answers.store', $question->id) }}" method="POST">
	@csrf
	<input type="hidden" name="question_id" value="{{ $question->id }}">

	<div class="form-group">
		<h5 for="body">{{ auth()->user()->profileName }}</h5>
	    <textarea class="form-control" name="body" id="body" rows="5" required></textarea>
	</div>

	<button class="btn btn-success" type="submit">Send</button>
</form>

@endsection


@section('right_sidebar')
	<li class="list-group-item">
	  <a class="btn btn-info" href="{{ route('admin.questions.edit', $question->id) }}">Edit</a>
	</li>

	<form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST">
		@method('DELETE')
		@csrf

		<li class="list-group-item">
		  <button type="submit" class="btn btn-danger">Delete</button>
		</li>  	  
		
	</form>	
@endsection
