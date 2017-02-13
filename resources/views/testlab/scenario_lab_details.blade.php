
@extends('layouts.lab_app')

@section('content')


<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
    <div class="panel-title" style="font-weight:bold;" > LAB Details for Scenario : {{$scenario->tsc_name}}
    </div>
    <p>
        Created at - {{date($dt_format, strtotime($scenario->created_at))}} 
    </p>
    <!-- Toast -->
    <p>
        @include('toast::messages')
        @if(Session::has('toasts'))
        {{Session::forget('toasts')}}
        @endif
    </p>
    <!-- Toast ENDs -->
    

    <div class="panel panel-default">

   <div class="panel-body"> 
 
   <div class="panel"> 
   
    <h4 style="display: inline-block;">
       Actions
    </h4>

    <p style="float:right;">
        <a href="{{URL::route('scenario.edit', ['id' => $scenario->tsc_id])}}" title="Edit Testcase"> <span id="" class="glyphicon glyphicon-edit"></span> Edit</a>

        <a  data-toggle="modal" data-target="#deleteModal" title="Delete Scenario"> <i class="glyphicon glyphicon-trash"  ></i> Delete
        </a>               
    </p>
    </div>

   <div class="panel-title"> 
        <div class="col-lg-6">
             <div class="row">
                <h4 style="font-style: bold;  padding: 5px;" >Manual Testing</h4>
            </div>
            <div class="row">
                   <div class="col-lg-6">
                      <a  title="Download Result format Sheet" href="{{URL::route('format_download', ['type' => 'scenario', 'id' => $scenario->lab->scl_id])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Result Format
                      </a>  
                  </div>
                  <div class="col-lg-6">
                   <a  data-toggle="modal" data-target="#uploadResultModal" title="Upload Results"> <i class="glyphicon glyphicon-upload"  ></i> Upload Manual Results
                   </a> 
               </div>
            </div>
      </div>
      <div class="col-lg-6">
        <div class="row">
          <h4 style="font-style: bold;  padding: 5px;" >Automation Testing</h4>
        </div>
        <div class="row" >
          <div class="col-lg-6">
           <a  title="Download Execute Sheet for AutoRun" href="{{URL::route('script_download', ['type' => 'scenario', 'id' => $scenario->lab->scl_id])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Execution Script
                      </a>
                  <!--     
             <a  data-toggle="modal" data-target="#downloadModal" title="Download Excel"> <i class="glyphicon glyphicon-cloud-download"  ></i> Download Execution Script
             </a>  -->   
         </div>
         <div class="col-lg-6">
          <a href="{{URL::route('execute.process', ['id' => $scenario->lab->scl_id])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute Automation</a>
         </div>
        </div>
      </div>
    </div>

    </div>
    </div>
<div class="panel-body" style="padding-bottom: 0px;">

    <h4 style="float:left">
        Summary
    </h4>         
</div>

<div class="panel-body" style="padding-top: 0px;">

    <div class="row" > 
        <div  class="col-lg-4"  style="padding-top: 10px;">

            <div class="row">                    
                <div  class="col-lg-6" >Result :
                </div>
                <div  class="col-lg-6" ><strong>{{($scenario->lab->result == '' || $scenario->lab->result == null ) ? "Not Executed" : $scenario->lab->result}}</strong>
                </div>
            </div>
            <div class="row">                    
                <div  class="col-lg-6" >Execution Type :
                </div>
                <div  class="col-lg-6" ><strong>{{$labs[0]->execution_type}}</strong>
                </div>
            </div>

        </div>


        <div  class="col-lg-4"  style="padding-top: 10px;">


            <div class="row">                    
                <div  class="col-lg-6" >Release :
                </div>
                <div  class="col-lg-6" ><strong>{{$labs[0]->release_version}}</strong>
                </div>
            </div>
            <div class="row">                    
                <div  class="col-lg-6" >Network :
                </div>
                <div  class="col-lg-6" ><strong>{{$labs[0]->network_type}}</strong>
                </div>
            </div>                        
        </div>

        <div  class="col-lg-4"  style="padding-top: 10px;">
            <div class="row">                    
                <div  class="col-lg-6" >OS : 
                </div>
                <div  class="col-lg-6" ><strong>{{$labs[0]->os_version}}</strong>
                </div>
            </div>

            <div class="row">                    
                <div  class="col-lg-6" >Device :
                </div>
                <div  class="col-lg-6" ><strong>{{$labs[0]->device_name}}</strong>
                </div>
            </div>


        </div>                            
    </div>
</div>
<hr/>
        <!-- <div class="panel-body">
	         <div class="panel-title" style="font-style: bold; padding-bottom: 10px;" > Testcases Details 
	         <p style="float:right">

                <a  data-toggle="modal" data-target="#downloadModal" title="Download Excel"> <i class="glyphicon glyphicon-cloud-download"  ></i> Download
                </a>

		        	<a href="{{URL::route('execute.show', ['id' => $tc_ids])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute</a>
		 	 </p>
         </div> -->
         @include('modals.download_modal')
         @include('modals.upload_result_modal') 


	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
  -->

  
  <div class="panel-body" style="padding-top: 0px"> 
    <h4 style="display: block;">
       Testase Details
    </h4>
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

     @foreach($labs as $detail) 				

     <?php 
                	//DEBUG
         			//echo " Labs for ".$detail->tc_name." = ".count($detail->lab_details)."<br/>";
     ?>
     <tr>
        <td> 
           {{$i++}}        				
       </td>
       <td> 
        <a href="{{URL::route('lab.show', ['id' => $detail->tl_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
           {{$detail->case->tc_name}} Lab</a>     				
       </td>
       <td>  
           {{$detail->case->description}}          				
       </td>
       <td> 
           {{date($dt_format, strtotime($detail->created_at))}}  	
       </td>
   </tr>
   @endforeach

</tbody>
</table>
</div>
</div>
</div>    
</div>
@endsection
