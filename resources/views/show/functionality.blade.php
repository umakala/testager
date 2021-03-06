
@extends('layouts.app')


@section('upload_modal')
		<?php $call_page = 'functionality';  $id = $functionality->tf_id;?>
	    @include('modals.upload_modal')
@endsection

@section('delete_modal')
	<?php $delete_type = 'functionality'; $id = $functionality->tf_id ;?>
    @include('modals.delete_modal')
@endsection


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > Functionality : {{$functionality->tf_name}}
		 </div>
		 	<p style="float:right">
		 		<a href="{{URL::route('functionality.edit', ['id' => $functionality->tf_id])}}"> <span id="" class="glyphicon glyphicon-edit" title="Edit Functionality"></span></a>
		 		<a type="button" data-toggle="modal" data-target="#uploadModal"> <i class="glyphicon glyphicon-upload" title="Upload Scenarios"></i>    
                </a>
                <a type="button" data-toggle="modal" data-target="#deleteModal"> <i class="glyphicon glyphicon-trash"  title="Delete Functionality"></i>
                </a>
		 	</p>


			<p>
	        	Created at - {{date($dt_format, strtotime($functionality->created_at))}} 
	        	by {{$functionality->created_by}}
	 		</p> 
	 		<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
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
				<div class="col-lg-2">
					Total Scenarios
				</div>
				<div class="col-lg-6">
        			{{$functionality->scenarios}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-2">
					Total Testcases
				</div>
				<div class="col-lg-6">
        			{{$functionality->cases}}
				</div>				
			</div>
			<div class="row">
				<div class="col-lg-2">
					Total Steps
				</div>
				<div class="col-lg-2">
        			{{$functionality->steps}}
				</div>
				<div class="col-md-8" style="text-align: right">
				<!-- Lab for this fucntionality - to be implemented -->
				<!-- <a href="{{URL::route('tf_lab', ['id' => $functionality->tf_id])}}" title="Go to TestLab for this functionality" > <span id="" class="glyphicon glyphicon-play-circle" ></span> Lab</a> -->


				<a type="button" data-toggle="modal" data-target="#cloneModal" title="Copy existing Scenario"> <i class="glyphicon glyphicon-copy"></i> Clone Scenario                                          
				</a>
				</div>				
			</div>
        </div>

        <?php $clone_type = 'scenario'?>  
    	@include('modals.clone_modal')
    	

        @include('lists.scenarios')
       
    </div> 

</div>
@endsection
