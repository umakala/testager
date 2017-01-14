
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" >Testcase : {{$case->tc_name}} 
		 </div>

	 		 <p>
	        	Created at - {{date($dt_format, strtotime($case->created_at))}} by {{$case->created_by}}
	 		</p>

	 		<!-- Toast -->
			<p>
			@include('toast::messages')
			@if(Session::has('toasts'))
			        {{Session::forget('toasts')}}
			@endif
			</p>
	 		<!--  <div class="panel-body">
			<p  onclick="hideSummary()">
		      <a data-toggle="collapse" data-parent="#panel" href="#summary_body" class="panel-toggle">
		        <span class="glyphicon glyphicon-eye-close"  id="icontoggle"></span><span style="font-style: bold; font-size: 16px; padding: 5px;" >Summary</span>
		      </a>
		  	</p>
			</div> -->
	 	
	 	 <div id="summary_body" class="panel-default">
	        <div class="panel-body">		

				<div class="row" style="padding: 10px">
					
					<div class="col-lg-4">
					
	 
					</div>
					<div class="col-lg-2">
						<span class="alert alert-info" style="padding: 5px">Total</span>
					</div>		

					<div class="col-lg-2">
						<span class="alert alert-success" style="padding: 5px">Passed</span>
					</div>	

					<div class="col-lg-2">
						<span class="alert alert-danger" style="padding: 5px">Failed</span>			
					</div>	

					<div class="col-lg-2">
						<span class="alert alert-warning" style="padding: 5px">Not Executed</span>
					</div>			
				</div>
				
				<div class="row">
					<div class="col-lg-4">
						 Teststeps Summary
					</div>
					<div class="col-lg-2">
	        			{{ isset($case->steps['total']) ? $case->steps['total'] : 0 }}
					</div>
					<div class="col-lg-2">
	        			{{ isset($case->steps['passed']) ? $case->steps['passed'] : 0 }}
					</div>
					<div class="col-lg-2">
	        			{{ isset($case->steps['failed']) ? $case->steps['failed'] : 0 }}
	        		
					</div>
					<div class="col-lg-2">
					{{ isset($case->steps['not_executed']) ? $case->steps['not_executed'] : 0 }}
	        		</div>				
				</div>
	        </div>
		</div>

		@if(!isset($case->steps['not_executed']) || count($case->steps['not_executed']) == 0)
         <div class="alert alert-warning" style="text-align: center;">Please Add Test Steps first. 

        		<a href="{{url('teststep/create',['tc_id' => $case->tc_id])}}"><span id="" class="glyphicon glyphicon-plus" tooltip="Click here to add step"></span> Add Step </a>
				</div>
      	@else

        <div class="panel-body">
	         <div class="panel-title" style="font-style: bold; padding-bottom: 10px;" > Teststeps Details 
	         <p style="float:right">

				<a href="{{URL::route('download.show', ['id' => $case->tc_id])}}"> <span id="" class="glyphicon glyphicon-download"></span> Download</a>
		        	<a href="{{URL::route('execute.show', ['id' => $case->tc_id])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute</a>
		 	 </p>
	 	</div>

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
         <table class="table table-striped" cellspacing="0" width="auto">
         	<thead>
         		<tr>
         			<th>#</th>
         			<th>Description</th>
         			<th>Status</th>
					<th>Executed by</th>
					<th>Execution at</th>					
					<th>Execution Result</th>
					<th>Checkpoint Result</th>
					<th>Defect ID</th>
					<th>Defect Status</th>
         		</tr>
         	</thead>
         	<tbody>
         		<?php
         		 $i =1; 
         		?>
         		@foreach($lab_details as $detail)
         		<tr>
         			<td> 
         				{{$i++}}        				
         			</td>
         			<td> 
         				{{$detail->description}}        				
         			</td>
         			<td class="alert alert-warning">  
         				{{$detail->status}}          				
         			</td>
         			<td> 
         				{{$detail->executed_by}}       				
         			</td>
         			<td> 
         				{{$detail->executed_at}}        				
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
        </div>
        @endif
    </div>    
</div>
@endsection
