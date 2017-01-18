
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">
    
    
  <div class="panel panel-default" style=" padding:10px">
    <a href="#top" class="float_button"><span class="glyphicon glyphicon-upload"></span></a>

        <div class="panel-title" style="font-weight:bold;" > Defects for Project {{$project->tp_name}}   {{$project->release}}
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

        @if(count ($lab_results) == 0)

             <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > No Defects Available
            
             <p style="float:right">
             </p>
            </div>      
        @else
        
            <div class="panel-title" style="font-weight: bold;" >  Summary 

            <div class="row">
                <div  class="col-lg-6" >
                    <div id="execution_result_chart"></div>
                    @piechart('exe_result', 'execution_result_chart')
                </div>

                <div  class="col-lg-6" >
                    <div id="checkpoint_result_chart"></div>
                    @piechart('cp_result', 'checkpoint_result_chart')
                </div>                             
            </div>
        </div>
            <div class="panel-body"  id ="top">

            <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All Defects 
            
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
                    <th>Defects id</th>
                    <th>Description</th>
                    <th>Release</th>
                    <th>Status</th>
                    <th>Reported Details</th>
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
                    <a href="{{URL::route('defect.show', ['id' => $detail->id])}}">
                        {{$detail->defect_id}}</a>                     
                    </td>
                    <td> {{$detail->description}}</td>
                    <td>  
                        {{$detail->release_version}}                         
                    </td>
                    <td>  
                        {{$detail->status}}                         
                    </td>
                    <td> 
                        Reported by                     
                        {{$detail->reported_by}} at {{date($exe_dt_format, strtotime($detail->created_at))}}               
                    </td>
                  
                   <!--  <td> 
                        <input type="checkbox" id="checkbox_{{$detail->tc_id}}">                    
                    </td> -->
                </tr>
                @endforeach
            </tbody>
         </table>
         @endif
        </div>
    </div>    
</div>
@endsection