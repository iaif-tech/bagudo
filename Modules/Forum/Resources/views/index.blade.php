@extends('forum::layouts.master')

@section('page-title')
    {{ Breadcrumbs::render('family.forum.index',[profile()->family]) }}
@endsection
@section('page-content')

<div class="row">
	<div class="col-sm-6">
		<a href="{{route('nuclear.forum.index',[profile()->family->name,'nuclear-forum'])}}">
			<button class="btn btn-block btn-primary">
				Nuclear Family Forum
			</button>
		</a>
	</div>
	<div class="col-sm-6">
		<a href="{{route('extended.forum.index',[profile()->family->name,'extended-forum'])}}">
			<button class="btn btn-block btn-primary">
				Extended Family Forum
			</button>
		</a>
	</div>
</div>
@endsection