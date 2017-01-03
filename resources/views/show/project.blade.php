
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Project : {{$project->tp_name}}   {{$project->release}}
		 </div>
	 		 <p style="float:right">
	        	<a href="{{URL::route('project.edit', ['id' => $project->tp_id])}}"> <span id="" class="glyphicon glyphicon-edit"></span></a>
	 		</p>
			 <p>
	        	Created at - {{$project->created_at}} by {{$project->created_by}}
	 		</p>
	 		 
        <div class="panel-body">
         <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Description 	</div>	
			<p>
	        	{{$project->description}}
			</p>     
        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Summary 	</div>	
			<div class="row">
				<div class="col-lg-6">
					Total Functionalities
				</div>
				<div class="col-lg-6">
					{{$project->functionalities}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Scenarios
				</div>
				<div class="col-lg-6">
        			{{$project->scenarios}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Testcases
				</div>
				<div class="col-lg-6">
        			{{$project->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-6">
					Total Steps
				</div>
				<div class="col-lg-6">
        			{{$project->steps}}
				</div>				
			</div>
        </div>
    </div>    
</div>
@endsection
