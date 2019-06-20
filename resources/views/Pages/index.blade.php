@extends('layouts.app')

@section('content')
    <div class="container">
    	@if(session('message'))
            <div class="alert alert->success">{{session('message')}}</div>
    	@endif
    	<ul>
    		@foreach($pages as $page)
		        <li>
		        	<h2 style="style: none">
		        		<a href="/blog/page/{{$page->slug()}}/{{$page->id}}/view">
		        			{{$page->page}}
		        		</a>
		        	</h2>
		        </li>
		    @endforeach
    	</ul>
	   
		<button data-toggle="modal" data-target="#create_page" class="btn btn-primary">{{'+'}}</button>
		<!-- modal -->
		<div class="modal fade" id="create_page" role="dialog">
		    <div class="modal-dialog">
		      <!-- Modal content-->
		        <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		        </div>
		        <div class="modal-body">
		            <form method="post" action="{{route('page.create')}}">
		                @csrf
		                <input type="text" name="page" class="form-control" placeholder="page title">
		                <br>
		                <button class="btn btn-primary">Create Page</button>
		            </form>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
		    </div>
		</div>
		<!-- end modal --> 
	</div>
@endsection
