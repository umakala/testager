  <div class="panel panel-default" style=" padding:10px">
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
			
  			</div>
  		</div>
      
       
        </div>
	</div>
</div>   