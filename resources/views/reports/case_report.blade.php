
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">
    
    
  <div class="panel panel-default" style=" padding:10px">
    <a href="#top" class="float_button"><span class="glyphicon glyphicon-upload"></span></a>

        <div class="panel-title" style="font-weight:bold;" > Teststeps detail report for {{$execution_results->case->tc_name}} for release {{$execution_results->lab->release_version}}
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
                <div  class="col-lg-4 col-sm-12" style=" padding-top: 30px;"><div class="panel-title" style="padding-bottom: 10px; font-size: 12px" >  
                <div class="row" >

                    <div  class="col-lg-12">
                      
                      
                        <div class="row">                    
                            <div  class="col-lg-6" >Release
                            </div>
                            <div  class="col-lg-6" ><strong> {{$execution_results->lab->tp_name}} {{$execution_results->lab->release_version}} </strong>
                            </div>
                        </div>
                        <div class="row">                    
                            <div  class="col-lg-6" >Functionality
                            </div>
                            <div  class="col-lg-6" ><strong> 
                            <a href="{{URL::route('report.functionality', ['id' => $execution_results->lab->tf_id])}}">

                            {{$execution_results->tf_name}} 
                            </a>
                            </strong>
                            </div>
                        </div>

                          <div class="row">                    
                            <div  class="col-lg-6" >Scenario
                            </div>
                            <div  class="col-lg-6" ><strong> 
<a href="{{URL::route('report.scenario', ['id' => $execution_results->lab->tsc_id])}}">
 
{{$execution_results->tsc_name}}  </a></strong>
                            </div>
                        </div>

                          <div class="row">                    
                            <div  class="col-lg-6" >Testcase
                            </div>
                            <div  class="col-lg-6" ><strong>
<a href="{{URL::route('report.lab', ['id' => $execution_results->lab->tc_id])}}">
                            {{$execution_results->case->tc_name}} 
                            </a>

                            </strong>
                            </div>
                        </div>
                    </div>


                    <div  class="col-lg-12"  style="padding-top: 10px;">
                        <div class="row">                    
                            <div  class="col-lg-6" >Network
                            </div>
                            <div  class="col-lg-6" >{{$execution_results->lab->network_type}}
                            </div>
                        </div>
                        <div class="row">                    
                            <div  class="col-lg-6" >OS
                            </div>
                            <div  class="col-lg-6" >{{$execution_results->lab->os_version}}
                            </div>
                        </div>

                         <div class="row">                    
                            <div  class="col-lg-6" >Device
                            </div>
                            <div  class="col-lg-6" >{{$execution_results->lab->device_name}}
                            </div>
                        </div>

                        <div class="row">                    
                            <div  class="col-lg-6" >Execution
                            </div>
                            <div  class="col-lg-6" >{{$execution_results->lab->execution_type}}
                            </div>
                        </div>
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
                   <!--  <a href="{{URL::route('report.case', ['id' => $detail->tl_id])}}"> -->
                        {{$detail->step->description}}<!-- </a>  -->                    
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