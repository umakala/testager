
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > {{$step->description}} 
		 </div>
			<p style="float:right">
	        	<a href="{{URL::route('teststep.edit', ['id' => $step->ts_id])}}"> <span id="" class="glyphicon glyphicon-edit"></span></a>
	 		</p>
			 
			 <p>
	        	Created at - {{$step->created_at}} <!-- by {{$step->created_by}} -->
	 		</p>
 			<p>
	        	Status : {{$step->status}} 
	 		</p>

        <div class="panel-body">
		
        <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Expected Result 	</div>
			<p>
	        	{{$step->expected_result}}
			</p> 
			    
        </div>       
		     
        </div>       
    </div>    
</div>
@endsection
