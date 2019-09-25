<li class="list-group-item">

	<div class="d-flex justify-content-between">
		<div class="">
			<h6>
				<a class="d-inline" 
				href="{{ route('admin.users.info', $answer->user->name) }}">
					{{ $answer->user->profileName }}
				</a>

				<div class="d-inline text-muted">
					{{ '@' . $answer->user_id }}
				</div>
			</h6>	

			<div>{{ $answer->body }}</div>
			
			<small class="text-muted ml-2">{{ $answer->created_at }}</small>
		</div>

		
		<div class="d-flex  justify-content-between">
			
			<div class="d-flex align-items-start">
				
				{{ $add_field ?? '' }}

				<a href="{{ route('admin.answers.edit', $answer->id) }}" 
				class="btn btn-primary mr-2">
					Edit
				</a>

				<form class="" method="POST" 
				action="{{ route('admin.answers.destroy', $answer->id) }}">
					@method('DELETE')
					@csrf
					<button class="btn" type="submit">Delete</button>
				</form>	

			</div>
		</div>
	</div>
	
	<div class="btn btn-success mb-2" disabled>
		Likes: {{ $answer->likes_count }}
	</div>

	@component('admin.components.answer_comments_tab')
		@slot('answer', $answer)
	@endcomponent
</li>