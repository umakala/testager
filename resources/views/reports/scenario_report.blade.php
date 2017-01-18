
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
            <div class="panel-title" style="font-weight: bold;" >  Summary 

            <div class="row">
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
             <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All TestCases
            
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
                    <th>Testcase</th>
                    <th>TestScenario</th>
                    <th>Functionality</th>
                    <th>Release</th>
                    <th>Status</th>
                    <th  width="200px">Execution Details</th>
                    <th>Execution Result</th>
                    <th>Checkpoint Result</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $i =1; 
                ?>
                @foreach($lab_results as $detail)
                <tr>
                    <td> 
                        {{$i++}}                        
                    </td>
                    <td> 
                    <a href="{{URL::route('report.case', ['id' => $detail->lab->tl_id])}}">
                        {{$detail->tc_name}}</a>                     
                    </td>
                    <td> {{$detail->tsc_name}}</td>
                    
                    <td> 
                    {{$detail->tf_name}}                     
                    </td>
                    <td>  
                        {{$detail->lab->release_version}}                         
                    </td>
                    <td>  
                        {{$detail->status}}                         
                    </td>
                    <td> 
                        {{$detail->lab->execution_type}} by                     
                        {{$detail->lab->executed_by}} at {{date($exe_dt_format, strtotime($detail->lab->created_at))}}               
                    </td>
                  
                    <td class="alert alert-{{$detail->lab->execution_result == 'Pass'? 'success' : ($detail->lab->execution_result == '' ? 'warning' : 'danger')}}"   > 
                        {{$detail->lab->execution_result}} 
                    </td>
                    <td class="alert alert-{{$detail->lab->checkpoint_result == 'Pass'? 'success' : ($detail->lab->checkpoint_result == '' ? 'warning': ($detail->lab->checkpoint_result == 'none' ? 'error' : 'danger'))}}" > 
                         {{$detail->lab->checkpoint_result == 'none' ? 'Not Defined' : $detail->lab->checkpoint_result}}
                    </td>
                    <td> 
                        <a href="{{URL::route('report.lab', ['id' => $detail->tc_id] )}}">  <span class="glyphicon glyphicon-calendar"></span> Lab History
                        </a>           
                    </td>
                </tr>
                @endforeach
            </tbody>
         </table>
        </div>
    </div>    
</div>
@endsection