 <div class="panel-body" style="overflow-x: scroll" id="list">
	       <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All Functionalities </div>	

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
	 		<div class="panel-title" style="font-weight: bold; float: right; " > 
	 	
	 		</div>
	 		<input type="hidden" name="tsc_id" value="{{$id}}">

         <table class="table table-striped" cellspacing="0"  >
         	<thead>
         		<tr>
      			<th style="max-width:10px">#</th>
      			<th style="min-width:150px">Name</th>
      			<th style="min-width:150px">Description</th>
					<th>Total Scenarios</th>
               <th style="max-width:100px">Created by</th>
					<th style="max-width:50px"> Created on </th>
               <th style="min-width:100px"> Actions </th>
             	</tr>
         	</thead>
         	<tbody>
         		<?php
         		 $i =1; 
         		?>
         		@foreach($functionalities as $detail)
         		<tr>
         			<td> 
         				{{$i++}}        				
         			</td>
         			<td> 
         			<a href="{{URL::route('functionality.show', ['id' => $detail->tf_id])}}">
         				{{$detail->tf_name}}</a>     				
         			</td>
         			<td>  
         				{{($detail->description == "" ) ? "-" : $detail->description}}          				
         			</td>
         			<td> 
         				{{$detail->scenarios}}
         			</td>
         			<td> 
         				{{$detail->created_by}} 
         			</td>
         			<td> 
         				{{date($small_dt_format, strtotime($detail->created_at))}} 
         			</td>
         			
         			<td> 

                  <a href="{{URL::route('functionality.show', ['id' => $detail->tf_id])}}" style="margin-right: 10px"> <span id="" class="glyphicon glyphicon-eye-open"></span></a>	

                  <a href="{{URL::route('functionality.edit', ['id' => $detail->tf_id])}}" style="margin-right: 10px"> <span id="" class="glyphicon glyphicon-pencil"></span></a> 
                  
         			</td>
         		</tr>
         		@endforeach
         	</tbody>
         </table>
		
        </div>

</div>