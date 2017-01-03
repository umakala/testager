
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > {{$step->tc_name}} 
		 </div>
			 <p>
	        	Created at - {{$step->created_at}} <!-- by {{$step->created_by}} -->
	 		</p> 
        <div class="panel-body">
			<p>
	        	Description of step !
	        	{{$step->description}}
			</p>     
        </div>       
    </div>    
</div>
@endsection
