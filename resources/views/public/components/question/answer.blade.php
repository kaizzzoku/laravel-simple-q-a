<li class="list-group-item">

	<div class="d-flex justify-content-between">
		<div class="">
			<h6>
				<a class="d-inline" 
				href="{{ route('users.info', $answer->user->name) }}">
					{{ $answer->user->profileName }}
				</a>

				<div class="d-inline text-muted">
					{{ '@' . $answer->user_id }}
				</div>				
			</h6>

			<div>{{ $answer->body }}</div>
			
			<small class="text-muted ml-2">{{ $answer->created_at }}</small>
		</div>
		
		<div class="d-flex justify-content-between">
			@if(auth()->id() === $answer->user_id)
				<div class="d-flex align-items-start">

					{{ $add_field ?? '' }}

					<a href="{{ route('answers.edit', $answer->id) }}"
					class="btn btn-primary mr-2">
						Edit
					</a>

					<form class="" method="POST"
					action="{{ route('answers.destroy', $answer->id) }}">
						@method('DELETE')
						@csrf
						<button class="btn" type="submit">Delete</button>
					</form>
												
				</div>
			@endif		
		</div>
	</div>

	@auth
		@user_liked($answer->likes)
			@slot('like_btn')
				<a href="{{ route('answers.removeLike', $answer->id) }}"
				class="btn btn-success mb-2">
					You like it
					{{ $answer->likes_count
						? '| ' . $answer->likes_count : ''}}
				</a>
			@endslot
		@else
			@slot('like_btn')
				<a href="{{ route('answers.addLike', $answer->id) }}"
				class="btn btn-outline-success mb-2">
					Like
					{{ $answer->likes_count
						? '| ' . $answer->likes_count : ''}}
				</a>
			@endslot
		@enduser_liked		
	@endauth

	@component('public.components.answer_comments_tab')
		@slot('answer', $answer)
	@endcomponent
</li>