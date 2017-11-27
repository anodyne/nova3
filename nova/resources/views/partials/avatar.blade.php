<div class="avatar-container">
@if ($type == 'link')
	<a href="{{ $link }}" class="avatar {{ $size }}" style="background-image:url({{ $url }})"></a>
@else
	<div class="avatar {{ $size }}" style="background-image:url({{ $url }})"></div>
@endif

@if ($label)
	<div>
		@if ($size == 'lg')
			<div class="avatar-label ml-3">
				<span class="h1">{!! $user->present()->name !!}</span>
				<span class="text-muted">
					@if ($labelContentBefore !== null)
						<span>{!! $labelContentBefore !!}</span>
						<span class="px-1">&bull;</span>
					@endif

					@if ($labelContentAfter !== null)
						<span class="px-1">&bull;</span>
						<span>{!! $labelContentAfter !!}</span>
					@endif
				</span>
			</div>
		@elseif ($size == 'md')
			<div class="avatar-label ml-3">
				<span class="h4">{!! $user->present()->name !!}</span>
				<span class="text-muted">
					@if ($labelContentBefore !== null)
						<span>{!! $labelContentBefore !!}</span>
						<span class="px-1">&bull;</span>
					@endif

					@if ($labelContentAfter !== null)
						<span class="px-1">&bull;</span>
						<span>{!! $labelContentAfter !!}</span>
					@endif
				</span>
			</div>
		@elseif ($size == 'sm')
			<div class="avatar-label ml-2">
				<span class="h5 mb-0">{!! $user->present()->name !!}</span>
			</div>
		@elseif ($size == 'xs')
			<div class="avatar-label ml-2">
				<span class="h6 mb-0">{!! $user->present()->name !!}</span>
			</div>
		@else
			<div class="avatar-label ml-3">
				<span class="h6 mb-1">{!! $user->present()->name !!}</span>
				<small class="text-muted">
					@if ($labelContentBefore !== null)
						<span>{!! $labelContentBefore !!}</span>
						<span class="px-1">&bull;</span>
					@endif

					@if ($labelContentAfter !== null)
						<span class="px-1">&bull;</span>
						<span>{!! $labelContentAfter !!}</span>
					@endif
				</small>
			</div>
		@endif
	</div>
@endif
</div>