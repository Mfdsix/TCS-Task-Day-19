@extends('layouts.master')

@section('content')
<div class="container py-5">
	<div class="row">
		<div class="col-md-8">
			<?php 
			if($blog->image != null){
				?>
				<img class="img-fluid" src="{{ asset('storage/'.$blog->image) }}" alt="Card image cap">
				<?php 
			}else{
				?>
				<img class="img-fluid" src="https://beritakota.co.id/wp-content/plugins/penci-portfolio//images/no-thumbnail.jpg" alt="Card image cap">
				<?php 
			}
			?>
			<div class="mt-3">
				<h3><?= $blog->title ?></h3>
				<p>Ditulis oleh : <a href="{{ url('blog/author/'.$blog->user->id) }}"><?= $blog->user->name ?> <i>(<?= $blog->user->email ?>)</i></a></p>
			</div>
			<hr>
			<p>
				<?= $blog->content; ?>
			</p>
		</div>

		<div class="col-md-4">
			<h3>Blog Terkait</h3>
			<hr>

			@if(count($blogs) == 0)
				<div class="text-center">Tidak Ada Blog Terkait</div>	
				@else
					@foreach($blogs as $key => $value)
						<div class="panel mb-2" style="border: 1px solid #ddd">
							<div class="panel-body">
								<div class="p-4">
									<?php 
									if($value->image != null){
										?>
										<img style="height: 100px; object-fit: cover; width: 100%" src="{{ asset('storage/'.$value->image) }}" alt="Card image cap">
										<?php 
									}else{
										?>
										<img class="img-fluid" src="https://beritakota.co.id/wp-content/plugins/penci-portfolio//images/no-thumbnail.jpg" alt="Card image cap">
										<?php 
									}
									?>
									<div class="mt-3">
										<a href="{{ url('blog/'.$value->id) }}"><h5>{{ $value->title }}</h5></a>
									</div>
									<hr>
									<p>
										{{ substr($value->content,0,60) }}...
									</p>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	@endsection