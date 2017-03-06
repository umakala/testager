
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">
    
    
  <div class="panel panel-default" style=" padding:10px">
    <a href="#top" class="float_button"><span class="glyphicon glyphicon-upload"></span></a>

        <div class="panel-title" style="font-weight:bold;" > Functionality wise Scenario level report for {{$project->tp_name}} 
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
            <div class="panel-title" style="font-weight: bold;" >  All Labs Summary 

            <div class="row">
               <div  class="col-lg-3 col-sm-12" >               
                    <div id="execution_result_chart"></div>
                    @piechart('exe_result', 'execution_result_chart')
                </div>

               <div  class="col-lg-3 col-sm-12" >               
                    <div id="result_chart"></div>
                    @piechart('cp_result', 'result_chart')
                </div> 

                <div  class="col-lg-6 col-sm-12" >   
                <table class="table table-striped" style="border: none; font-size: 12px; " cellspacing="0" width="auto">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th style="vertical-align: middle;">Functionality</th>
                            <th colspan="4" style="text-align: center;">Testlabs</th>
                            <th colspan="4" style="text-align: center;">Teststeps</th><!-- 
                            <th colspan="3" style="text-align: center;">Scenarios</th> -->
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="alert alert-info">Total</th>
                            <th class="alert alert-success">Pass</th>
                            <th class="alert alert-danger">Fail</th>
                            <th class="alert error"  style="font-size:10px;">Not <br/>executed</th>

                            <th class="alert alert-info">Total</th>
                            <th class="alert alert-success">Pass</th>
                            <th class="alert alert-danger">Fail</th>
                            <th class="alert error" style="font-size:10px;">Not <br/> executed</th>

                           <!-- <th class="alert alert-info">Total</th>
                            <th class="alert alert-success">Pass</th>
                            <th class="alert alert-danger">Fail</th> -->
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $i =1; 
                        ?>
                        @foreach($project->functionalities as $fn)
                        <tr>
                            <td> 
                                {{$i++}}                        
                            </td>
                            <td> 
                                <a href="{{URL::route('sc_report.functionality', ['id' => $fn->tf_id])}}" title="All Scenario Labs for {{$fn->tf_name}} "> 
                                {{$fn->tf_name}}                    
                                </a>
                            </td>
                            <td class="alert alert-info">
                               {{ isset($fn->testcases['total']) ? $fn->testcases['total'] : 0 }}
                            </td>
                            <td class="alert alert-success">
                               {{ isset($fn->testcases['pass']) ? $fn->testcases['pass'] : 0 }}
                                                             
                            </td>
                            <td class="alert alert-danger">
                               {{ isset($fn->testcases['fail']) ? $fn->testcases['fail'] : 0 }}                               
                            </td>
                            <td class="alert alert-error">
                               {{ isset($fn->testcases['not_executed']) ? $fn->testcases['not_executed'] : 0 }}                               
                            </td>
                            <td class="alert alert-info">
                               {{ isset($fn->teststeps['total']) ? $fn->teststeps['total'] : 0 }}                                
                            </td>
                            <td  class="alert alert-success">
                               {{ isset($fn->teststeps['pass']) ? $fn->teststeps['pass'] : 0 }}
                                
                            </td>
                            <td  class="alert alert-danger">
                               {{ isset($fn->teststeps['fail']) ? $fn->teststeps['fail'] : 0 }}
                                
                            </td>
                             <td  class="alert alert-error">
                               {{ isset($fn->teststeps['not_executed']) ? $fn->teststeps['not_executed'] : 0 }}
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                 </table>
                </div>
            </div>
        </div>



        <div class="panel-body"  id ="top">
             <div class="panel-title" style="padding-bottom: 10px;" > Testcase Details 
             <p  onclick="hideSummary()" style="float:right">
              <a data-toggle="collapse" data-parent="#panel" href="#summary_body" class="panel-toggle">
                <span class="glyphicon glyphicon-filter"  id="icontoggle"></span><span style="font-style: bold; font-size: 14px; padding: 5px;" >Filters</span>
              </a>
            </p>
            <p  style="float:right">
              <a href="{{URL::route('sc_report.index')}}" style="font-size: 14px; padding: 5px;">All Scenario Labs Report
              </a><a href="{{URL::route('report.index')}}" >
                <span class="glyphicon glyphicon-show"  id="icontoggle"></span><span style="font-size: 14px; padding: 5px;" >All Test Labs Report</span>
              </a>
            </p>

        </div>
        
         <div id="summary_body" class="panel-collapse collapse"  >
            <div class="panel-body" style="font-size:12px">        
                <div class="row">
                    <div class="col-lg-6">
                   <!--  <form action="{{URL::route('download.store', ['id' => ''])}}" method ="POST" class="">
                        <div class="form-group">
                            <label for="os_version" class="control-label col-xs-4">Filter by Functionality</label>
                            <div class="col-xs-6">
                                <select class="form-control" name="os_version"  style="font-size:12px">
                                    @foreach($project->functionalities as $fn)
                                        <option value="{{$fn->tf_id}}">{{$fn->tf_name}}</option>
                                    @endforeach
                              </select>
                           </div>
                        </div>
                        </form> -->
     
                    </div>
                </div>
            </div>
        </div>
    </div>

        
        <!--  Column details of test case to show 
        id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
        -->
         <table class="table table-striped" cellspacing="0" width="auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th >TestScenario</th>
                    <th >Functionality</th>
                    <th>Release</th>
                   <!--  <th>Status</th> -->
                    <th  width="200px">Execution Details</th>
                    <th>Result</th>
                    <th colspan="2">Actions</th>

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
                        
                        <td style="max-width: 200px; overflow-wrap: normal;">
                            <a href="{{URL::route('report.scenario', ['id' => $detail->tsc_id])}}" title="{{$detail->description}}">
                            <strong>{{$detail->tsc_name}} </strong> 
                            <span>
                            {{" - ".substr($detail->description, 0, 100).".."}}
                            </span>

                            </a>
                        </td>                        
                        <td> 
                            <a href="{{URL::route('report.functionality', ['id' => $detail->tf_id])}}">                            
                            {{$detail->tf_id}}  
                            </a>                   
                        </td>
                        <td>  
                            {{isset($detail->lab->release_version)? $detail->lab->release_version : ""}}                         
                        </td>
                        <!-- <td>  
                            {{$detail->status}}                         
                        </td> -->
                        <td> 
                            {{isset($detail->lab->execution_type)? $detail->lab->execution_type : ""}}                         
                             by  
                            {{isset($detail->lab->executed_by)? $detail->lab->executed_by : ""}}                         
                            at 
                            {{isset($detail->lab->created_at)? date($exe_dt_format, strtotime($detail->lab->created_at)) : ""}}                                    
                        </td>
                       <form action="{{URL::route('report.update', ['id' => $detail->lab->scl_id])}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' > 
                      <input type="hidden" name="_method" value="PUT"> 
                      <input type="hidden" name="type" value="scenariolab">              
                        <td class="alert alert-{{$detail->lab->result == 'Pass'? 'success' : ($detail->lab->result == '' || $detail->lab->result == 'not_executed' ? 'warning': ($detail->lab->result == 'none' ? 'error' : 'danger'))}}" > 
                    <select class="alert" name="result">
                      <option value="Pass"  class="alert alert-success"
                          {{ $detail->lab->result == "Pass" ? 'selected' : ''}}>Pass</option>
                      <option value="Fail" class="alert alert-danger"
                          {{ $detail->lab->result == "Fail" ?  'selected' : '' }}>Fail</option>
                      <option value="" class="alert alert-warning"
                          {{ $detail->lab->result == ""  ?  'selected' : '' }}>Not Available</option>
                      <option value="none" class="alert alert-error"
                          {{ $detail->lab->result == "none"  ?  'selected' : '' }}>Not Defined</option>
                          </select>   

                            <!--  {{$detail->lab->result == 'none' ? 'Not Defined' : $detail->lab->result}} -->
                        </td>
                        <td>

                        @if($detail->lab->result == '')
                                <button type="submit" title="Select scenarios and Go to Testlab" name="">Update Result</button>
                        @endif
<!-- 
                        <a href="{{URL::route('report.edit', ['id' => $detail->lab->tl_id] )}}">  <span class="glyphicon glyphicon-edit"></span> Edit Result
                            </a>  -->
                        </td>
                        </form>
                        <td>
                            <a href="{{URL::route('report.sc_lab', ['id' => $detail->tsc_id] )}}">  <span class="glyphicon glyphicon-calendar"></span> Scenario Lab History
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