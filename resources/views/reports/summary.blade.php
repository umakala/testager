
@extends('layouts.lab_app')

@section('content')
<div class="wrapper">


  <div class="panel panel-default" style=" padding:10px">
    
    <div class="panel-title" style="font-weight:bold;" > Functionality-wise Scenario Summary
    </div>

    <!-- Toast -->
    <p>
      @include('toast::messages')
      @if(Session::has('toasts'))
      {{Session::forget('toasts')}}
      @endif
    </p>            

    <div class="panel-body" >
    

<!--      Table Starts -->
      <div  class="col-md-8 col-sm-12" style="overflow-x: scroll">


      @include('modals.summary_panel')
      <table id="scTBL" class="table table-striped table-hover" cellspacing="0" width="auto" >
          <thead>
            <tr>
              <th width="10px">#</th>
              <th>Functionality</th>
              <th >Planned</th>
              <th>Labs</th>
              <th>Pass</th>
              <th>Fail</th>
              <th style="max-width: 50px">Not Available</th>
              <th>Balance</th>              
            </tr>                         
          </thead>
          <tbody>
          <?php $i=1; ?>
            @foreach($functionalities as $fn)
            <tr>
              <td> 
                {{$i++}}                        
              </td>
              <td> 
                <a href="{{URL::route('report.functionality', ['id' => $fn->tf_id])}}" title="All test Labs for {{$fn->tf_name}} "> 
                  {{$fn->tf_name}}                    
                </a>
              </td>
              <td>{{$fn->sc_count}}</td> 
              <td>{{$fn->sc_labs_count}}</td>
              <td>{{$fn->pass}}</td>
              <td>{{$fn->fail}}</td>
              <td>{{$fn->not_available}}</td>              
              <td>{{$fn->balance}}</td>             
          </tr>
         @endforeach 
            <tr style="font-weight: bold">
              <td> 
                   TOTAL           
              </td>
              <td> 
                {{count($functionalities)}}                    
              </td>
              <td>{{$report['sc_total']}}</td> 
              <td>{{$report['total']}}</td> 
              <td>{{$report['pass']}}</td> 
              <td>{{$report['fail']}}</td> 
              <td>{{$report['not_available']}}</td> 
              <td>{{$report['balance']}}</td>
          </tr>                          
       </tbody>
     </table>
     </div>
  <!--      Table Ends -->

    <!--  Pie Charts Starts -->

 
      <div  class="col-md-4 col-sm-12" > 
        <div class="row"> 
        <div id="sc_vs_labs_chart"></div>
          @columnchart('sc_result', 'sc_vs_labs_chart')
        </div>
        <div class="row" >   
        <div id="labs_summary_chart"></div>
          @piechart('result', 'labs_summary_chart')
        </div>
      </div>

    <!--  Pie Charts Ends -->

   </div>
 </div>
</div>    
</div>

<script type="text/javascript">
    $("#scTBL").DataTable({ responsive: true});
</script>
@endsection