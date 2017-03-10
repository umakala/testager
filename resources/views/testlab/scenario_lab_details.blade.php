
@extends('layouts.lab_app')

@section('content')

<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
    <div class="panel-title" style="font-weight:bold;" >LAB Details for Scenario : {{$scenario->tsc_name}}
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
  @include('lists.sc_lab_details_cases')
  

</div>
</div>    
</div>
@endsection
