
@extends('layouts.lab_app')

@section('content')


<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Executing Testcases for Scenario : {{$scenario->tsc_name}}
		 </div>
	 		 <p>
	        	Created at - {{date($dt_format, strtotime($scenario->created_at))}} <!-- by {{$scenario->created_by}} -->
	 		</p>

	 		
	 		<!-- Toast -->
			<p>
			@include('toast::messages')
			@if(Session::has('toasts'))
			        {{Session::forget('toasts')}}
			@endif
			</p>
	 		 <div class="panel-body">
			
			</div>
	 	

	 	@if(!isset($cases) || count($cases) == 0)
         <div class="alert alert-warning" style="text-align: center;">Please Select a Testcase first. 

        		<a href="javascript:history.back()"><span id="" class="glyphicon glyphicon-arrow-left" tooltip="Click here to go back"></span> Go Back </a>
				</div>
      	@else

        <div class="panel-body">
	         <div class="panel-title" style="font-style: bold; padding-bottom: 10px;" > Testcases Details 
	         <p style="float:right">

				<a href="{{URL::route('download.show', ['id' => $tc_ids])}}"> <span id="" class="glyphicon glyphicon-download"></span> Download</a>
		        	<a href="{{URL::route('execute.show', ['id' => $tc_ids])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute</a>
		 	 </p>
	 	</div>

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
         <table class="table table-striped" cellspacing="0" width="auto">
         	<thead>
         		<tr>
         			<th>#</th>
         			<th>Case Name</th>
         			<th>Status</th>
					<th>Execution type</th>
					<th>Executed by</th>
					<th>Created at</th>					
					<th>Execution Result</th>
					<th>Checkpoint Result</th>
					<th>Defect Count</th>
					<th>Defect Status</th>
         		</tr>
         	</thead>
         	<tbody>
         		<?php
         		 $i =1; 
         		?>

         		@foreach($cases as $detail) 				
         		
         		<?php 
         			//DEBUG
         			//echo " Labs for ".$detail->tc_name." = ".count($detail->lab_details)."<br/>";
          		?>
         		<tr>
         			<td> 
         				{{$i++}}        				
         			</td>
         			<td> 
         			<a href="{{URL::route('lab.show', ['id' => $detail->tc_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
         				{{$detail->tc_name}}  Lab</a>     				
         			</td>
         			<td class="alert alert-warning">  
         				{{$detail->status}}          				
         			</td>
         			<td> 
         				{{$detail->execution_type}}
         			</td>
         			<td> 
         				{{$detail->executed_by}}       				
         			</td>
         			<td> 
         				{{date($dt_format, strtotime($detail->created_at))}}        				
         			</td>
         			<td> 
         				{{$detail->execution_result}} 
         			</td>
         			<td> 
         				{{$detail->checkpoint_result}}  
         			</td>
         			<td> 
         				-      				
         			</td>
         			<td> 
         				-
         			</td>
         		</tr>
         		@endforeach

         	</tbody>
         </table>
         @endif
        </div>
    </div>    
</div>
@endsection
