
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">
    
    
  <div class="panel panel-default" style=" padding:10px">
    <a href="#top" class="float_button"><span class="glyphicon glyphicon-upload"></span></a>

        <div class="panel-title" style="font-weight:bold;" > Scenario Lab Execution History report for Scenario - {{$lab_results[0]->scenario[0]->tsc_name}}
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
                <div  class="col-lg-12" >
                    <div id="execution_result_chart"></div>
                    @piechart('result', 'execution_result_chart')
                </div>                             
            </div>
        </div>

        <div class="panel-body"  id ="top">
             <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All TestLabs 
            
             <p style="float:right">
             </p>
        </div>

        <!--  Column details of test scenario to show 
        id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
        -->
         <table class="table table-striped" cellspacing="0" width="auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TestScenario</th>
                    <th>Functionality</th>
                    <th>Release</th>
                    <th  width="200px">Execution Details</th>
                    <th>Result</th>
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
 <a href="{{URL::route('report.scenario', ['id' => $detail->tsc_id])}}">
                    {{$detail->tsc_name}}
</a>
                    </td>
                    
                    <td> 
 <a href="{{URL::route('report.functionality', ['id' => $detail->tf_id])}}">
                        {{$detail->tf_name}}                     
                  </a>  
                    </td>
                    <td>  
                        {{$detail->release_version}}                         
                    </td>
                
                    <td> 
                        {{$detail->execution_type}} by                     
                        {{$detail->executed_by}} at {{date($exe_dt_format, strtotime($detail->created_at))}}               
                    </td>
                  
                    <td class="alert alert-{{$detail->result == 'Pass'? 'success' : ($detail->result == '' ? 'warning' : ($detail->result == 'none' ? 'error' : 'danger'))}}" > 
                        {{$detail->result == 'none' ? 'Not Defined' : $detail->result}}  
                    </td>
                </tr>
                @endforeach
            </tbody>
         </table>
        </div>
    </div>    
</div>
@endsection