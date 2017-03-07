
@extends('layouts.app')

@section('upload_modal')
		<?php $call_page = 'scenario';  $id = $scenario->tsc_id; ?>
	    @include('modals.upload_modal')
@endsection

@section('delete_modal')
	<?php $delete_type = 'scenario'; $id = $scenario->tsc_id;?>
    @include('modals.delete_modal')
@endsection

@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Scenario : {{$scenario->tsc_name}} 
		 </div>
		 	 <p>
	        	Created at : {{date($dt_format, strtotime($scenario->created_at))}} <!-- by {{$scenario->created_by}} -->
	 		</p>

	 		<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p>

	 		<!-- Body -->
		<div class="panel-body">
			<p style="float:right">
				<a href="{{URL::route('scenario.edit', ['id' => $scenario->tsc_id])}}" title="Edit Testcase"> <span id="" class="glyphicon glyphicon-edit"></span> Edit</a>

				<a  data-toggle="modal" data-target="#deleteModal" title="Delete Scenario"> <i class="glyphicon glyphicon-trash"  ></i> Delete
                </a>               
			</p>

		</div>

        <div class="panel-body">

        <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Description 	</div>
			<p>
	        	{{$scenario->description}}
			</p> 


        <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Expected Result 	</div>
			<p>
	        	{{$scenario->expected_result}}
			</p>
			    
        </div>       
		<div class="panel-body">
			 <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Summary 	
			 </div>	
			<div class="row">
				<div class="col-md-2">
					Total Testcases
				</div>
				<div class="col-md-8">
        			{{$scenario->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-md-2">
					Total Steps
				</div>
				<div class="col-md-2">
        			{{$scenario->steps}}
				</div>				
			
				<div class="col-md-8" style="text-align: right">				

				<a type="button" data-toggle="modal" data-target="#cloneModal" title="Copy existing Testcases"> <i class="glyphicon glyphicon-copy"></i> Clone Testcase                                          
				</a> 

				<a href="{{url('testcase/create',['tsc_id' => $scenario->tsc_id])}}" title="Add New Teststep"><span id="" class="glyphicon glyphicon-plus"></span> Add Testcase </a>


				<a type="button" data-toggle="modal" data-target="#uploadModal" title="Upload Testcases"> <i class="glyphicon glyphicon-upload"></i> Upload                                         
				</a>
			
				</div>
  			</div>
  		</div>
      
        <?php $clone_type = 'testcase'?>  
    	@include('modals.clone_modal') 
       	@include('lists.cases')
        </div>
	</div>
</div>   
</div>
@endsection
