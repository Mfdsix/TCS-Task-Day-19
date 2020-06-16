@extends('layouts.master')

@section('content')

<div class="container py-5">
	<div class="row">
		<div class="col-md-6 m-auto">
			<div class="card">
				<div class="card-header">
					<h3>Buat Blog</h3>
				</div>
				<div class="card-body">
					@if($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<form method="post" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<label>Judul</label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required="">
						</div>
						<div class="form-group">
							<label>Konten</label>
							<textarea rows="5" class="form-control" name="content" id="content" required="">{{ old('content') }}</textarea>
						</div>
						<div class="form-group">
							<label>Kategori</label>
							<select name="category_id" required="" class="form-control">
								<option value="">Pilih Kategori</option>
								@foreach($categories as $k => $v)
								<option value="{{ $v->id }}">{{ $v->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>File</label>
							<input type="file" name="image" id="image" class="form-control">
						</div>
						<hr>
						<div class="form-group">
							<button class="btn btn-warning btn-block">Submit</button>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>
</div>

@endsection