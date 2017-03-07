
@extends('layouts.app')


@section('content')
<div class="wrapper">
  <div class="panel panel-default" style=" padding:10px">
        <div class="panel-title" style="font-weight:bold;" > {{$step->description}} 
		 </div>
			<p style="float:right">
	        	<a href="{{URL::route('teststep.edit', ['id' => $step->ts_id])}}"> <span id="" class="glyphicon glyphicon-edit"></span></a>

	        	<a data-toggle="modal" data-target="#deleteModal" title="Delete Testcase"> <i class="glyphicon glyphicon-trash"  ></i>
        		</a>
	 		</p>
			 
			 <p>
	        	Created at - {{date($dt_format, strtotime($step->created_at))}} <!-- by {{$step->created_by}} -->
	 		</p>

	 		<p>
	        	@include('toast::messages')
				@if(Session::has('toasts'))
				        {{Session::forget('toasts')}}
				@endif
	 		</p>
 			


	 	<ol class="breadcrumb">
          <li><a href="{{URL::route('testcase.show' , ['id' => $step->tc_id] )}}">Case {{$step->tc_name}}</a></li>
          <li class="active">  <a href="{{URL::route('teststep.show' , ['id' => $step->ts_id] )}}">Teststep</a></li>
        </ol>


        <div class="panel-body">		
        <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Expected Result 	</div>
			<p>
	        	{{$step->expected_result}}
			</p> 			    
        </div>  


        <div class="panel-body">		
        <div class="panel-title" style="font-style: italic; padding-bottom: 10px;" > Element Details 	</div>

        	 <table class="table table-striped" cellspacing="0" width="auto">
         	<thead>
         		<tr>
         			<th>#</th>
         			<th>Scroll</th>
         			<th>Resource-id</th>
					<th>Text</th>
					<th>Content-desc</th>
					<th>Class</th>					
					<th>Index</th>
					<th>Sendkey</th>
					<th>Screenshot</th>
					<th>Checkpoint</th>
					<th>Wait</th>
         		</tr>
         		<tr>
         			<td>#</td>
         			<td>{{$execution->scroll}}</td>
         			<td>{{$execution->resource_id}}</td>
					<td>{{$execution->text}}</td>
					<td>{{$execution->content_desc}}</td>
					<td>{{$execution->class}}</td>					
					<td>{{$execution->index}}</td>
					<td>{{$execution->sendkey}}</td>
					<td>{{$execution->screenshot}}</td>
					<td>{{$execution->checkpoint}}</td>
					<td>{{$execution->wait}}</td>
         		</tr>
         	</thead>
         	<tbody>
         	</tbody>
         	</table>
        </div>      
		     
        </div>  
        @section('delete_modal')
		  <?php $delete_type = 'teststep'; $id = $step->ts_id ;?>
		    @include('modals.delete_modal')
		@endsection
     
    </div>    
</div>
@endsection
