
@extends('layouts.app')

@section('upload_modal')
		<?php $call_page = 'testcase'; $id = $case->tc_id; ?>
	    @include('modals.upload_modal')
@endsection

@section('delete_modal')
	<?php $delete_type = 'testcase'; $id = $case->tc_id ;?>
    @include('modals.delete_modal')
@endsection

@section('content')
<script type="text/javascript">
/*$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
*/		
</script>

<div class="wrapper">
	<div class="panel panel-default" style=" padding:10px">

		<!-- Title -->
		<div class="panel-title" style="font-weight:bold;" > Testcase : {{$case->tc_name}} 
		</div>
		<p>
			Created at : {{date($dt_format, strtotime($case->created_at)) }}
		</p>

		<!-- Toast -->
		<p>@include('toast::messages')
		@if(Session::has('toasts'))
		        {{Session::forget('toasts')}}
		@endif
		</p>

		<!-- Body -->
		<div class="panel-body">
			<p style="float:right">
				<a href="{{URL::route('testcase.edit', ['id' => $case->tc_id])}}" title="Edit Testcase"> <span id="" class="glyphicon glyphicon-edit"></span> Edit</a>

				

				<a  data-toggle="modal" data-target="#deleteModal" title="Delete Testcase"> <i class="glyphicon glyphicon-trash"  ></i>Delete
                </a>
			</p>			
			<p>
				Status : {{$case->status}} <!-- by {{$case->created_by}} -->
			</p> 
		</div>

		<div class="panel-body">
			<div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Description 	</div>
			<p>
				{{$case->description}}
			</p> 


			<div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > Expected Result 	</div>
			<p>
				{{$case->expected_result}}
			</p> 
		</div> 

		<div class="panel-body">
			<div class="panel-title" style="font-weight:bold; padding-bottom: 10px;" > Summary 	</div>	
			<div class="row">
				<div class="col-lg-2">
					Total Steps
				</div>
				<div class="col-lg-6">
					{{count($case->steps)}}
				</div>				

				<div class="col-lg-4" style="text-align: right">					
				<a href="{{url('teststep/create',['tc_id' => $case->tc_id])}}" title="Add New Teststep"><span id="" class="glyphicon glyphicon-plus"></span> Add Step </a>
				
				<a type="button" data-toggle="modal" data-target="#uploadModal" title="Upload Teststeps"> <i class="glyphicon glyphicon-upload"></i>Upload                                        
				</a>

				<a href="{{URL::route('lab.show', ['id' => $case->tc_id])}}" title="Go to Testlab" > <span id="" class="glyphicon glyphicon-play-circle" ></span> Lab</a>
				

	
				</div>	
					<div  style="text-align: right; padding-top: 50px;">					
				
					<a type="button" data-toggle="modal" data-target="#uploadExecutionModal" title="Upload Teststeps using Execution Input Sheet"> <i class="glyphicon glyphicon-upload"></i>Upload  Execution Sheet                                       
					</a>	
					</div>		
			</div>
		</div>


		<?php $call_teststep_page = 'teststep'; $id = $case->tc_id; ?>
	    @include('modals.upload_execution_modal')


		<!-- Details of test steps -->

		<div class="panel-body">
			<div class="panel-title" style="font-weight:bold; padding-bottom: 10px;" > Teststeps 	</div>
			<div class="row">
    	
    	<div class="col-sm-12">
	 	<form action="{{URL::route('step.reorder', ['id' => $case->tc_id])}}" method="POST">

        <table class="table">
            <thead>
                <tr>
                    <th  style="max-width: 10%">
                    	<a data-toggle="tooltip"  title="Click on values to change order" class="glyphicon glyphicon-ok" style="font-size: 10px" ></a><button class="link_button" type="submit"  title="Click to save reorder changes" >Reorder</button>
                    	</th>
                    <th style="max-width: 30%">Description</th>
                    <th style="max-width: 25%">Expected Result</th>
                    <th style="max-width: 5%">Status</th>                    
                    <th style="max-width: 20%"> Actions <!-- Execution Format --></th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1;?>
            @foreach($case->steps as $step)
                <tr>
                    <td class="col-sm-1">
                     <input type="number" name="{{$step->ts_id}}" id="{{'input'.$step->seq_no}}" value="{{$step->seq_no}}"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="width: 40px; border:none;"   min="1"  max="{{count($case->steps)}}" onchange="validate_order(this.value)">
                    </td>
                    <td class="col-sm-3" >
                     <a style="margin-right: 10px" href="{{URL::route('teststep.show' , ['id' => $step->ts_id])}}">{{$step->description}} </a>
                    </td>
                    <td class="col-sm-3">               
                    {{$step->expected_result}}
                    </td>
                    <td class="col-sm-2"> 
                    {{$step->status}}
                    </td>
                    <td class="col-sm-1" >
                     <a class="glyphicon glyphicon-eye-open" style="margin-right: 10px" href="{{URL::route('teststep.show' , ['id' => $step->ts_id])}}"></a>
          
                    	 <a class="glyphicon glyphicon-pencil" style="margin-right: 10px" href="{{URL::route('teststep.edit' , ['id' => $step->ts_id])}}"></a>     
                		<!-- <a class="btn-sm" data-toggle="modal" data-target="#deleteModal"> <i class="glyphicon glyphicon-trash"></i> Delete </a> -->
                		
                    </td>
                </tr>
               @endforeach
            </tbody>
        </table>
        </form>
    </div>
</div>



		</div>
	</div>    
</div>


@endsection
