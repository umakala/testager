
@extends('layouts.lab_app')

@section('content')


<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Executing Testcases
		 </div>
	 		<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p> 

        <div class="panel-body">
	         <div class="panel-title" style="font-style: bold; padding-bottom: 10px;" > Testcases 
	         <!-- <p style="float:right">
		        	<a href="{{URL::route('project.edit', ['id' => ''])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Show Results</a>
		 	 </p> -->
	 	</div>

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
         <table class="table table-striped" cellspacing="0" width="auto">
         	<thead>
         		<tr>
         			<th style="max-width: 10px">#</th>
         			<th style="max-width: 150px">Case Name</th>
         			<th>Status</th>
					<th>Execution type</th>
					<th>Executed by</th>
					<th>Execution Start time</th>					
					<th style="min-width: 100px">Execution Result</th>
					<th style="min-width: 100px">Checkpoint Result</th>
					
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
         			<a href="{{URL::route('lab.show', ['id' => $detail->tc_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
         				{{$detail->tc_name}}    Lab</a>     				
         			</td>
         			<td class="alert alert-warning">  
         				Executing <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate active"></span>

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
<!-- <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
    <span class="sr-only">45% Complete</span>
  </div>
</div> -->
	        		</td>  
	        		<td>
	        			
	        		</td>       		
         		</tr>
         		@endforeach
         	</tbody>
         </table>
        </div>
    </div>    
</div>
@endsection
