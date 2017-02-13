
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
	 		 <!-- <div class="panel-body">
			     <div style="float:right">
              <a  title="Download Result format Sheet" href="{{URL::route('format_download', ['type' => 'scenario', 'id' => $scenario->tsc_id])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Result Format
                </a>  

                 <a  data-toggle="modal" data-target="#uploadResultModal" title="Upload Results"> <i class="glyphicon glyphicon-upload"  ></i> Upload Results
                </a> 
                </div>
			</div> -->
	 	

	 	@if(!isset($cases) || count($cases) == 0)
         <div class="alert alert-warning" style="text-align: center;">Please Select a Testcase first. 

        		<a href="javascript:history.back()"><span id="" class="glyphicon glyphicon-arrow-left" tooltip="Click here to go back"></span> Go Back </a>
				</div>
      	@else

        @include('modals.download_form')


        <!-- Download and Upload options commented below as not required on this page -->

        <!-- <div class="panel-body" style="padding-bottom:20px;">

        <div class="col-lg-6 panel-title"  >

            <div class="row">
                    <h4 style="font-style: bold;  padding: 5px;" >Manual Testing</h4>
            </div>
            <div class="row">
         <div >
         <div class="col-lg-6">
             
          <a  title="Download Result format Sheet" href="{{URL::route('format_download', ['type' => 'scenario', 'id' => $scenario->tsc_id])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Result Format
            </a>  
            </div>
            <div class="col-lg-6">
             
             <a  data-toggle="modal" data-target="#uploadResultModal" title="Upload Results"> <i class="glyphicon glyphicon-upload"  ></i> Upload Manual Results
            </a> 
            </div>
            </div>
            </div>
        </div>
 
            <div class="col-lg-6 panel-title">

            <div class="row">
                 <h4 style="font-style: bold;  padding: 5px;" >Automation Testing</h4>
            </div>
            <div class="row" >
             <div class="col-lg-6">
             <a  data-toggle="modal" data-target="#downloadModal" title="Download Excel"> <i class="glyphicon glyphicon-cloud-download"  ></i> Download Execution Script
            </a>    
            </div>
             <div class="col-lg-6">
            <a href="{{URL::route('execute.show', ['id' => $tc_ids])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute Automation</a>
            </div>
         </div>
         </div>
    </div> -->


        <div class="panel-body">
	         <div class="panel-title" style="font-style: bold; padding-bottom: 10px;" > Testcases Details 
	         <!-- <p style="float:right">

                <a  data-toggle="modal" data-target="#downloadModal" title="Download Excel"> <i class="glyphicon glyphicon-cloud-download"  ></i> Download
                </a>

		        	<a href="{{URL::route('execute.show', ['id' => $tc_ids])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute</a>
		 	 </p> -->
	 	</div>
        <!-- @include('modals.download_modal')
        @include('modals.upload_result_modal') 
         -->

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
         <table class="table table-striped" cellspacing="0" width="auto">
         	<thead>
         		<tr>
         			<th>#</th>
         			<th>Case Name</th>
         			<th>Description</th>
					<th>Created at</th>					
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
         			<td>  
         				{{$detail->description}}          				
         			</td>
         			<td> 
         				{{date($dt_format, strtotime($detail->created_at))}}  	
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
