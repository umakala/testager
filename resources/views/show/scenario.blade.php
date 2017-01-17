
@extends('layouts.app')

@section('upload_modal')
		<?php $call_page = 'scenario';  $id = $scenario->tsc_id; ?>
	    @include('modals.upload_modal')
@endsection

@section('delete_modal')
	<?php $delete_type = 'scenario'; $id = $scenario->tsc_id;?>
    @include('modals.delete_modal')
@endsection

@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Scenario : {{$scenario->tsc_name}} 
		 </div>
		 	 <p>
	        	Created at : {{date($dt_format, strtotime($scenario->created_at))}} <!-- by {{$scenario->created_by}} -->
	 		</p>

	 		<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p>

	 		<!-- Body -->
		<div class="panel-body">
			<p style="float:right">
				<a href="{{URL::route('scenario.edit', ['id' => $scenario->tsc_id])}}" title="Edit Testcase"> <span id="" class="glyphicon glyphicon-edit"></span> Edit</a>

				<a  data-toggle="modal" data-target="#deleteModal" title="Delete Scenario"> <i class="glyphicon glyphicon-trash"  ></i> Delete
                </a>
			</p>			
			<p>
				Status : {{$scenario->status}} 
			</p> 
		</div>
        <div class="panel-body">

        <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Description 	</div>
			<p>
	        	{{$scenario->description}}
			</p> 


        <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Expected Result 	</div>
			<p>
	        	{{$scenario->expected_result}}
			</p>
			    
        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Summary 	
			 </div>	
			<div class="row">
				<div class="col-lg-4">
					Total Testcases
				</div>
				<div class="col-lg-8">
        			{{$scenario->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-4">
					Total Steps
				</div>
				<div class="col-lg-4">
        			{{$scenario->steps}}
				</div>				
			
				<div class="col-lg-4" style="text-align: right">					
				<a href="{{url('testcase/create',['tsc_id' => $scenario->tsc_id])}}" title="Add New Teststep"><span id="" class="glyphicon glyphicon-plus"></span> Add Testcase </a>
				<a type="button" data-toggle="modal" data-target="#uploadModal" title="Upload Teststeps"> <i class="glyphicon glyphicon-upload"></i> Upload                                         
				</a>
			
				</div>
  			</div>
  		</div>

        <div class="panel-body" style="overflow-x: scroll">
	       <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All Testcases </div>	

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
         		@foreach($case_details as $detail)
         		<tr>
         			<td> 
         				{{$i++}}        				
         			</td>
         			<td> 
         			<a href="{{URL::route('testcase.show', ['id' => $detail->tc_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
         				{{$detail->tc_name}}</a>     				
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
			<!-- <div class="col-lg-8" style="text-align: right">					
			</div>
         	<div class="col-lg-4" style="text-align: right">					
				<a href="{{url('testcase/create',['tsc_id' => $scenario->tsc_id])}}" title="Add New Teststep"><span id="" class="glyphicon glyphicon-plus"></span> Add Testcase </a>
				<a type="button" data-toggle="modal" data-target="#uploadModal" title="Upload Teststeps"> <i class="glyphicon glyphicon-upload"></i> Upload                                         
				</a>
				<a role="submit" href="" title="Go to Testlab" > <span id="" class="glyphicon glyphicon-play-circle" ></span> Lab</a>
				</div> -->
        </div>

</div>
    </div>    
</div>
@endsection
