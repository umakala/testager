
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
        <div class="panel-body" style="overflow-x: scroll">
	       <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All Functionality </div>	

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
	 	<form action="{{URL::route('lab.store')}}" method="POST">
 			<div class="panel-title" style="font-weight: bold; float: right; " > 
	 	
	 		</div>
	 		<input type="hidden" name="tsc_id" value="{{$id}}">

         <table class="table table-striped" cellspacing="0"  >
         	<thead>
         		<tr>
         			<th style="max-width:10px">#</th>
         			<th style="min-width:150px">Case Name</th>
         			<th style="max-width:100px">Status</th>
					<th style="max-width:100px">Execution type</th>
					<th>Execution Result</th>
					<th>Checkpoint Result</th>
					<th><button type="submit"  title="Select cases and Go to Testlab" > <span id="" class="glyphicon glyphicon-play-circle" ></span> Lab</button>
					</th>
         		</tr>
         	</thead>
         	<tbody>
         		<?php
         		 $i =1; 
         		?>
         		@foreach($functionalities as $detail)
         		<tr>
         			<td> 
         				{{$i++}}        				
         			</td>
         			<td> 
         			<a href="{{URL::route('functionality.show', ['id' => $detail->tf_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
         				{{$detail->tf_name}}</a>     				
         			</td>
         			<td class="alert alert-warning">  
         				{{$detail->status}}          				
         			</td>
         			<td> 
         				{{$detail->execution_type}}
         			</td>
         			<td> 
         				{{$detail->execution_result}} 
         			</td>
         			<td> 
         				{{$detail->checkpoint_result}}  
         			</td>
         			
         			<td> 
					    <input type="checkbox" id="checkbox_{{$detail->tc_id}}" name="checkbox_{{$detail->tc_id}}">     				
         			</td>
         		</tr>
         		@endforeach
         	</tbody>
         </table>
         </form>
		
        </div>

</div>
    </div> 
</div>
@endsection
