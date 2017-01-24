
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">
    
    
  <div class="panel panel-default" style=" padding:10px">
    <a href="#top" class="float_button"><span class="glyphicon glyphicon-upload"></span></a>

        <div class="panel-title" style="font-weight:bold;" > TestLab Reports for Project {{$project->tp_name}}   {{$project->release}}
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
        
        <div class="panel-body" >
            <div class="panel-title" > Summary 
            <div class="row" >                 
                <div  class="col-lg-4 col-sm-12" style=" padding-top: 30px;">                
                    <div class="panel-title" style="padding-bottom: 20px; font-size: 14px" >  
                <div class="row">
                    <div  class="col-lg-8" >
                        <ul class="list-unstyled">
                            <li>Testcase : <strong> {{$execution_results->case->tc_name}}</strong></li>
                            <li>Scenario : <strong>{{$execution_results->tsc_name}}</strong></li>
                            <li>Functionality :<strong> {{$execution_results->tf_name}}</strong></li>
                            <li>Release : <strong>{{$execution_results->lab->release_version}}</strong></li>
                        </ul>                       
                    </div>
                    <div  class="col-lg-6" >
                        <ul class="list-unstyled">
                            
                            <li>Network :<strong> {{$execution_results->lab->network_type}}</strong></li>
                            <li>OS : <strong>{{$execution_results->lab->os_version}}</strong></li>
                            <li>Device :<strong> {{$execution_results->lab->device_name}}</strong></li>
                            <li>Execution type :<strong> {{$execution_results->lab->execution_type}}</strong></li>

                        </ul>                       
                    </div>                             
                </div>
                </div>
                </div>
                <div  class="col-lg-4 col-sm-12" >
                    <div id="execution_result_chart"></div>
                    @piechart('exe_result', 'execution_result_chart')
                </div>

                <div  class="col-lg-4 col-sm-12" >
                    <div id="checkpoint_result_chart"></div>
                    @piechart('cp_result', 'checkpoint_result_chart')
                </div>
            </div>
        </div>

        <div class="panel-body"  id ="top">
             <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All TestSteps 
            
             <p style="float:right">
             </p>
        </div>

        <!--  Column details of test case to show 
        id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
        -->
         <table class="table table-striped" cellspacing="0" width="auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TestStep</th>   
                    <th>Status</th>
                    <th  width="200px">Execution Details</th>
                    <th>Execution Result</th>
                    <th>Checkpoint Result</th>
                   <!--  <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                 $i =1; 
                ?>
                @foreach($execution_results as $detail)
                <tr>
                    <td> 
                        {{$detail->seq_no}}
                    </td>
                    <td> 
                    <a href="{{URL::route('report.case', ['id' => $detail->tl_id])}}">
                        {{$detail->step->description}}</a>                     
                    </td>
                    <td> 
                        {{$detail->ts_status}}                          
                    </td>
                    <td> 
                        {{$detail->execution_type}} by                     
                        {{$detail->executed_by}} at {{date($exe_dt_format, strtotime($detail->created_at))}}               
                    </td>
                  
                    <td class="alert alert-{{$detail->execution_result == 'Pass'? 'success' : ($detail->execution_result == '' ? 'warning' : 'danger')}}"   > 
                        {{$detail->execution_result}} 
                    </td>
                    <td class="alert alert-{{$detail->checkpoint_result == 'Pass'? 'success' : ($detail->checkpoint_result == '' ? 'warning' : ($detail->checkpoint_result == 'none' ? 'error' : 'danger'))}}" > 
                         {{$detail->checkpoint_result == 'none' ? 'Not Defined' : $detail->checkpoint_result}} 

                    </td>
                   <!--  <td> 
                        <a href="{{URL::route('report.lab', ['id' => $detail->tc_id ])}}">  <span class="glyphicon glyphicon-calendar"></span> Lab History
                        </a>           
                    </td> -->
                </tr>
                @endforeach
            </tbody>
         </table>
        </div>
    </div>    
</div>
@endsection