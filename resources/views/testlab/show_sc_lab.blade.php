
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

    
     @include('modals.sc_lab_details_action_summary')



	 	<!-- List of Testcases within test case   -->


   <div class="panel-body" style="padding-top: 0px"> 
    <h4 style="display: block;">
     Testcase labs
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
