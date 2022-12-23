@extends('templates.default')
@section('title', 'home page')
@section('content')

	<div class="row">
		<div class="col-md-8">
			<h1>welcome</h1>
			<span>stay in touch with friends</span>
		</div>
		<div class="col-md-4">
			@include('auth.signin')
			@include('auth.signup')
		</div>
	</div>
@endsection