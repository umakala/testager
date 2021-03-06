
@extends('layouts.lab_app')

@section('content')


<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Project : {{$project->tp_name}}   {{$project->release}}
         </div>
             <p>
                Created at - {{date($dt_format, strtotime($project->created_at))}} by {{$project->created_by}} 
            </p>

            <!-- Toast -->
            <p>
            @include('toast::messages')
            @if(Session::has('toasts'))
                    {{Session::forget('toasts')}}
            @endif
            </p>     

    <!--         <div class="panel-body">
            <p  onclick="hideSummary()">
              <a data-toggle="collapse" data-parent="#panel" href="#summary_body" class="panel-toggle">
                <span class="glyphicon glyphicon-eye-close"  id="icontoggle"></span><span style="font-style: bold; font-size: 16px; padding: 5px;" >Summary</span>
              </a>
            </p>

          </div>
        
         <div id="summary_body" class="panel-collapse collapse">
            <div class="panel-body">        

                <div class="row" style="padding: 10px">
                    
                    <div class="col-lg-2">
                    
     
                    </div>
                    <div class="col-lg-2">
                        <span class="alert alert-info" style="padding: 5px">Total</span>
                    </div>      

                    <div class="col-lg-2">
                        <span class="alert alert-warning" style="padding: 5px">Executed</span>
                    </div>  

                    <div class="col-lg-2">
                        <span class="alert alert-warning" style="padding: 5px">Not Executed</span>
                    </div>  

                    <div class="col-lg-2">
                        <span class="alert alert-success" style="padding: 5px">Passed</span>
                    </div>  

                    <div class="col-lg-2">
                        <span class="alert alert-danger" style="padding: 5px">Failed</span>         
                    </div>          
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        Functionalities
                    </div>
                    <div class="col-lg-2">
                        {{$project->functionalities}}
                    </div>  

                    <div class="col-lg-2">
                    -
                    </div>  

                    <div class="col-lg-2">
                    -
                    </div>  

                    <div class="col-lg-2">
                    -
                    </div>              
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        Scenarios
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->scenarios['total']) ? $project->scenarios['total'] : 0 }}
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->scenarios['executed']) ? $project->scenarios['executed'] : 0 }}
                    </div>  
                    <div class="col-lg-2">
                        {{ isset($project->scenarios['not_executed']) ? $project->scenarios['not_executed'] : 0 }}
                    </div>  

                    <div class="col-lg-2">
                        {{ isset($project->scenarios['passed']) ? $project->scenarios['passed'] : 0 }}
                        
                    </div>

                    <div class="col-lg-2">
                        {{ isset($project->scenarios['failed']) ? $project->scenarios['failed'] : 0 }}
                    </div>

                                
                </div>

                <div class="row">
                    <div class="col-lg-2">
                        Testcases
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->cases['total']) ? $project->cases['total'] : 0 }}
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->cases['executed']) ? $project->cases['executed'] : 0 }}

                    </div>
                   <div class="col-lg-2">
                        {{ isset($project->cases['not_executed']) ? $project->cases['not_executed'] : 0 }}

                    </div>    
                    <div class="col-lg-2">
                        {{ isset($project->cases['passed']) ? $project->cases['passed'] : 0 }}
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->cases['failed']) ? $project->cases['failed'] : 0 }}
                    </div>                                      
                </div>
                <div class="row">
                    <div class="col-lg-2">
                         Steps
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->steps['total']) ? $project->steps['total'] : 0 }}
                    </div>
                      <div class="col-lg-2">
                        {{ isset($project->steps['executed']) ? $project->steps['executed'] : 0 }}
                    </div> 
                      <div class="col-lg-2">
                        {{ isset($project->steps['not_executed']) ? $project->steps['not_executed'] : 0 }}
                    </div> 
                    <div class="col-lg-2">
                        {{ isset($project->steps['passed']) ? $project->steps['passed'] : 0 }}
                    </div>
                    <div class="col-lg-2">
                        {{ isset($project->steps['failed']) ? $project->steps['failed'] : 0 }}
                    
                    </div>             
                </div>
            </div>
        </div> -->

    <div class="panel-body" style="padding-bottom:20px;">

        <div class="col-lg-7 panel-title"  >

            <div class="row">
                    <h4 style="font-style: bold;  padding: 5px;" >Manual Testing</h4>
            </div>
            <div class="row">
         <div >
         <div class="col-lg-4">
             
          <a  title="Download Result format Sheet" href="{{URL::route('format_download', ['type' => 'all'])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Result Format
            </a>  
            </div>
            <div class="col-lg-4">
             
             <a  data-toggle="modal" data-target="#uploadResultModal" title="Upload Results"> <i class="glyphicon glyphicon-upload"  ></i> Upload Manual Results
            </a> 
            </div>
            <div class="col-lg-4">
            <!-- 
            Give type here instead and save it in session. Remove it from session as soon as report is clicked.  -->
             <a href="{{URL::route('lab.manual')}}"> <i class="glyphicon glyphicon-play"  ></i> Execute Manual
            </a> 
            </div>
            </div>
            </div>
        </div>
 
            <div class="col-lg-5 panel-title">

            <div class="row">
                 <h4 style="font-style: bold;  padding: 5px;" >Automation Testing</h4>
            </div>
            <div class="row" >
            <?php $tc_ids = $project->tp_id ?>  
             <div class="col-lg-6">
               <a  data-toggle="modal" data-target="#downloadModal" title="Download Excel"> <i class="glyphicon glyphicon-cloud-download"  ></i> Download Execution Script
            </a>    
            </div>
             <div class="col-lg-6">
            <a href="{{URL::route('execute.show', ['id' => $project->tp_id])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute Automation</a>
            </div>
         </div>
         </div>
    </div>

        <div class="panel-body">
             <div class="panel-title" style="font-style: bold; padding-bottom: 10px;" > All Testcases 
             
        </div>
        @include('modals.download_modal')
        
        @include('modals.upload_result_modal') 

        <!--  Column details of test case to show 
        id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
        -->
         <table class="table table-striped" cellspacing="0" width="auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Execution type</th>
                    <th>Executed by</th>
                    <th>Execution time</th>                 
                    <th>Execution Result</th>
                    <th>Checkpoint Result</th>
                   <!--  <th>Run</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                 $i =1;  $sc_i =1;
                ?>
                @foreach($lab_details as $sc)
                <tr>
                    <td> 
                        {{$sc_i++}}                        
                    </td>
                    <td> 
                    <a href="{{URL::route('tsc_lab', ['id' => $sc->tsc_id])}}"> <span id="" class="glyphicon glyphicon-"></span>
                        {{$sc->tsc_name}}
                    </td>
                </tr>
                    @foreach($sc->case as $detail)
                    <tr>
                        <td style="padding-left: 20px;"> 
                            {{$i++}}                        
                        </td>
                        <td> 
                        <a href="{{URL::route('lab.show', ['id' => $detail->tc_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
                            {{$detail->tc_name}}  </a>                     
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
                       <!--  <td> 
                            <input type="checkbox" id="checkbox_{{$detail->tc_id}}">                    
                        </td> -->
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
         </table>
        </div>
    </div>    
</div>
@endsection