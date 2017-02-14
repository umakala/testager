
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
                    <th colspan="2">Action</th>
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
                 <form action="{{URL::route('report.update', ['id' => $detail->scl_id])}}" method ="POST" class="form-horizontal"> 
                      <input type="hidden" name="_method" value="PUT"> 
                      <input type="hidden" name="type" value="scenariolab">             

                        <td class="alert alert-{{$detail->result == 'Pass'? 'success' : ($detail->result == '' || $detail->result == 'not_executed' ? 'warning': ($detail->result == 'none' ? 'error' : 'warning'))}}" > 
                    <select class="alert" name="result">
                      <option value="Pass"  class="alert alert-success"
                          {{ $detail->result == "Pass" ? 'selected' : ''}}>Pass</option>
                      <option value="Fail" class="alert alert-danger"
                          {{ $detail->result == "Fail" ?  'selected' : '' }}>Fail</option>
                      <option value="" class="alert alert-warning"
                          {{ $detail->result == ""  ?  'selected' : '' }}>Not Available</option>
                      <option value="none" class="alert alert-error"
                          {{ $detail->result == "none"  ?  'selected' : '' }}>Not Defined</option>
                          </select>   

                            <!--  {{$detail->result == 'none' ? 'Not Defined' : $detail->result}} -->
                        </td>
                        <td>
                                <button type="submit" title="Select scenarios and Go to Testlab" name="">Update Result</button>
                        <!-- 
                        <a href="{{URL::route('report.edit', ['id' => $detail->tl_id] )}}">  <span class="glyphicon glyphicon-edit"></span> Edit Result
                            </a>  -->
                            </td>
                            <td>
                            <a href="{{URL::route('sc_lab.show', ['id' => $detail->scl_id] )}}">  <span class="glyphicon glyphicon-eye-open"></span> Show Scenario Lab Details
                            </a> 
                        </td>
                        </form>
                </tr>
                @endforeach
            </tbody>
         </table>
        </div>
    </div>    
</div>
@endsection