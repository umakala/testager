
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" >{{$functionality->tf_name}}
		 </div>
		 	<p style="float:right">
		 		<a href="{{URL::route('functionality.edit', ['id' => $functionality->tf_id])}}"> <span id="" class="glyphicon glyphicon-edit"></span></a>
		 	</p>
			<p>
	        	Created at - {{$functionality->created_at}} 
	        	<!-- by {{$functionality->created_by}} -->
	 		</p> 
        <div class="panel-body">
         <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Description 	</div>
			<p>
	        	{{$functionality->description}}
			</p>     
        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Summary 	</div>	
			<div class="row">
				<div class="col-lg-6">
					Total Scenarios
				</div>
				<div class="col-lg-6">
        			{{$functionality->scenarios}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Testcases
				</div>
				<div class="col-lg-6">
        			{{$functionality->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Steps
				</div>
				<div class="col-lg-6">
        			{{$functionality->steps}}
				</div>				
			</div>
        </div>
    </div>    
</div>
@endsection
