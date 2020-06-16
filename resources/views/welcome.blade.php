@extends('layouts.master')

@section('content')
<div class="jumbotron">
	<div class="container">
		@if(auth()->check())
		<h1 class="display-4">Hello, {{ auth()->user()->name }}</h1>
		@else
		<h1 class="display-4">Hello</h1>
		@endif
		<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
		<hr class="my-4">
		<p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
		<a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
	</div>
</div>
@endsection