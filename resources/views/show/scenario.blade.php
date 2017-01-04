
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Scenario : {{$scenario->tsc_name}} 
		 </div>
		 <p style="float:right">
	        	<a href="{{URL::route('scenario.edit', ['id' => $scenario->tsc_id])}}"> <span id="" class="glyphicon glyphicon-edit"></span></a>
	 		</p>
			 
			 <p>
	        	Created at : {{$scenario->created_at}} <!-- by {{$scenario->created_by}} -->
	 		</p>

			 <p>
	        	Status : {{$scenario->status}}
	 		</p> 
        <div class="panel-body">

        <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Description 	</div>
			<p>
	        	{{$scenario->description}}
			</p> 


        <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Expected Result 	</div>
			<p>
	        	{{$scenario->expected_result}}
			</p> 
			    
        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Summary 	</div>	
			<div class="row">
				<div class="col-lg-6">
					Total Testcases
				</div>
				<div class="col-lg-6">
        			{{$scenario->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Steps
				</div>
				<div class="col-lg-6">
        			{{$scenario->steps}}
				</div>				
			</div>
        </div>
    </div>    
</div>
@endsection
