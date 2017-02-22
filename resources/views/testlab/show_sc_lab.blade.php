
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
 
   <div class="panel" style="padding: 10px"> 
   
    <h4 style="display: inline-block;">
       Actions
    </h4>

    <p style="float:right;">
        
        <a  data-toggle="modal" data-target="#deleteModal" title="Delete Scenario Lab"> <i class="glyphicon glyphicon-trash"  ></i> Delete
        </a>               
    </p>
    </div>
    <?php $delete_type="sc_lab" ; $id = $scenario->lab->scl_id; ?>
    @include('modals.delete_modal')

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

<div class="panel-body" style="padding-top: 0px;font-size: 12pt">

    <div class="row" > 
        <div  class="col-lg-4"  style="padding-top: 10px;">

            <div class="row">                    
                <div  class="col-lg-6" >Result :
                </div>
                <div  class="col-lg-6" >
              <form action="{{URL::route('report.update', ['id' => $scenario->lab->scl_id])}}" method ="POST"> 
                      <input type="hidden" name="_method" value="PUT"> 
                      <input type="hidden" name="type" value="scenariolab">             

                        <div class="alert alert-{{$scenario->lab->result == 'Pass'? 'success' : ($scenario->lab->result == '' || $scenario->lab->result == 'not_executed' ? 'warning': ($scenario->lab->result == 'none' ? 'error' : 'warning'))}}" style="padding:10px; "> 
                    <select class="alert" name="result" style="padding:5px; margin-bottom: 0px">
                      <option value="Pass"  class="alert alert-success"
                          {{ $scenario->lab->result == "Pass" ? 'selected' : ''}}>Pass</option>
                      <option value="Fail" class="alert alert-danger"
                          {{ $scenario->lab->result == "Fail" ?  'selected' : '' }}>Fail</option>
                      <option value="" class="alert alert-warning"
                          {{ $scenario->lab->result == ""  ?  'selected' : '' }}>Not Available</option>
                      <option value="none" class="alert alert-error"
                          {{ $scenario->lab->result == "none"  ?  'selected' : '' }}>Not Defined</option>
                          </select>  
                          </div>

                 <button type="submit" title="Select scenarios and Go to Testlab" name="">Update Result</button>

                 </form>
                </div>
            </div>           
        </div>


        <div  class="col-lg-4"  style="padding-top: 10px;">

            <div class="row">                    
                <div  class="col-lg-6" >Execution Type :
                </div>
                <div  class="col-lg-6" ><strong>{{$labs[0]->execution_type}}</strong>
                </div>
            </div>

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
         @include('modals.upload_result_modal') 


	 	<!--  Column scenario->labs of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
  -->

  
  <div class="panel-body" style="padding-top: 0px"> 
    <h4 style="display: block;">
       Testase scenario->labs
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

     @foreach($labs as $scenario->lab) 				

     <?php 
                	//DEBUG
         			//echo " Labs for ".$scenario->lab->tc_name." = ".count($scenario->lab->lab_scenario->labs)."<br/>";
     ?>
     <tr>
        <td> 
           {{$i++}}        				
       </td>
       <td> 
        <!-- <a href="{{URL::route('report.lab', ['id' => $scenario->lab->tl_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span> -->
           {{$scenario->lab->case->tc_name}}

       </td>
       <td>  
           {{$scenario->lab->case->description}}          				
       </td>
       <td> 
           {{date($dt_format, strtotime($scenario->lab->created_at))}}  	
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