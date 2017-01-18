
@extends('layouts.app')


@section('upload_modal')
		<?php $call_page = 'project'; $id = $project->tp_id;?>
	    @include('modals.upload_modal')
@endsection


@section('delete_modal')
	<?php $delete_type = 'project'; $id =  $project->tp_id;?>
    @include('modals.delete_modal')
@endsection


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Project : {{$project->tp_name}}   {{$project->release}}
		 </div>
	 		 <p style="float:right">
	        	<a href="{{URL::route('project.edit', ['id' => $project->tp_id])}}"> <span id="" class="glyphicon glyphicon-edit" title="Edit Project" ></span></a>
	        	<a type="button" data-toggle="modal" data-target="#uploadModal"> <i class="glyphicon glyphicon-upload"  title="Upload Functionalities"></i>                                           
                </a>
                <a type="button" data-toggle="modal" data-target="#deleteModal"> <i class="glyphicon glyphicon-trash"  title="Delete Project"></i>
                </a>
	 		</p>
			 <p>
	        	Created at - {{date($dt_format, strtotime($project->created_at))}} by {{$project->created_by}}
	 		</p>

	 		<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p>
	 		 
        <div class="panel-body">
         <div style="font-style: italic; padding-bottom: 10px;" > Package name 	
			<p>
	        	{{$project->package_name}}
			</p>     
		</div>

		 <div style="font-style: italic; padding-bottom: 10px;" > Activity name 	
			<p>
	        	{{$project->activity_name}}
			</p>     
		</div>

        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Summary 	</div>	
			<div class="row">
				<div class="col-lg-6">
					Total Functionalities
				</div>
				<div class="col-lg-6">
					{{$project->functionalities}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Scenarios
				</div>
				<div class="col-lg-6">
        			{{$project->scenarios}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Testcases
				</div>
				<div class="col-lg-6">
        			{{$project->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Steps
				</div>
				<div class="col-lg-6">
        			{{$project->steps}}
				</div>				
			</div>
        </div>
   		@include('lists.functionalities')
       
    </div> 
</div>
@endsection
