
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > {{$case->tc_name}} 
		 </div>
			 <p>
	        	Created at - {{$case->created_at}} <!-- by {{$case->created_by}} -->
	 		</p> 
        <div class="panel-body">
			<p>
	        	Description of case !
	        	{{$case->description}}
			</p>     
        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-weight:bold; padding-bottom: 10px;" > Summary 	</div>	
			<div class="row">
				<div class="col-lg-6">
					Total Steps
				</div>
				<div class="col-lg-6">
        			{{$case->steps}}
				</div>				
			</div>
        </div>
    </div>    
</div>
@endsection
