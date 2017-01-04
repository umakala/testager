
@extends('layouts.app')


@section('content')
<div class="wrapper">
	<div class="panel panel-default" style=" padding:10px">
		<div class="panel-title" style="font-weight:bold;" > Testcase : {{$case->tc_name}} 
		</div>

		<p>
			Created at : {{$case->created_at}} <!-- by {{$case->created_by}} -->
		</p> 
		<div class="panel-body">
			<p style="float:right">
				<a href="{{URL::route('testcase.edit', ['id' => $case->tc_id])}}"> <span id="" class="glyphicon glyphicon-edit"></span> Edit</a>

				<a href="{{URL::route('testcase.show', ['id' => $case->tc_id])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute</a>
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
				<a href="{{url('teststep/create',['tc_id' => $case->tc_id])}}"><span id="" class="glyphicon glyphicon-plus"></span> Add Step </a>
				</div>				
			</div>
		</div>
		<div class="panel-body">
			<div class="panel-title" style="font-weight:bold; padding-bottom: 10px;" > Teststeps 	</div>
			<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Step</th>
                    <th>Description(Click/input/select)</th>
                    <th>Execution Format</th>
                    <th>Expected Result</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1;?>
            @foreach($case->steps as $step)
                <tr>
                    <td class="col-sm-1">
                     {{"Step ".$i++}}
                    </td>
                    <td class="col-sm-3">
                    {{$step->description}}
                    </td>
                    <td class="col-sm-3">
                    {{$step->execution_format}}
                    </td>
                    <td class="col-sm-2">               
                    {{$step->execution_result}}
                    </td>

                    <td class="col-sm-1"> 
                    {{$step->status}}
                    </td>
                </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>



		</div>
	</div>    
</div>
@endsection
