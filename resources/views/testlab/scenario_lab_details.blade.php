
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
    

    <!-- Action and Summary boxes included -->
    @include('modals.sc_lab_details_action_summary')
    

  <!-- Testcase Details included -->
   <div class="panel-body" style="padding-top: 0px"> 
    <h4 style="display: block;">
     Testcase Details
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

   @foreach($labs as $detail) 				

   <?php 
                	//DEBUG
         			//echo " Labs for ".$detail->tc_name." = ".count($detail->lab_details)."<br/>";
   ?>
   <tr>
    <td> 
     {{$i++}}        				
   </td>
   <td> 
    <!-- <a href="{{URL::route('lab.show', ['id' => $detail->tl_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span> -->
     {{$detail->case->tc_name}} Lab</a>     				
   </td>
   <td>  
     {{$detail->case->description}}          				
   </td>
   <td> 
     {{date($dt_format, strtotime($detail->created_at))}}  	
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
