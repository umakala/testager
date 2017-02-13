 <div class="panel-body" style="overflow-x: scroll" id="list">
	       <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All Scenarios </div>	

	 	<!--  Column details of test case to show 
	 	id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
	 	-->
	 		<div class="panel-title" style="font-weight: bold; float: right; " > 
	 	
	 		</div>
	 		
         <form action="{{URL::route('lab.store')}}" method="POST">
      
         <input type="hidden" name="tf_id" value="{{$id}}">
         <input type="hidden" name="type" value="scenario">

         <table class="table table-striped" cellspacing="0"  >
         	<thead>
         		<tr>
      			<th style="max-width:10px">#</th>
      			<th style="min-width:150px">Name</th>
      			<th style="min-width:130px">Description</th>
					<th>Total Testcases</th>
               <th style="max-width:100px">Created by</th>
					<th style="max-width:50px"> Created on </th>
               <th style="min-width:100px"> Actions
               </th>
               <!-- <th style="min-width:100px"> 
               <input type="checkbox" id="select_all" name="select_all" title="Select all" onclick="checkAll(this)" />   

               <button type="submit"  title="Select scenarios and Go to Testlab" > <span id="" class="glyphicon glyphicon-play-circle" ></span> Lab</button>
                </th> -->
         		</tr>
         	</thead>
         	<tbody>
         		<?php
         		 $i =1; 
         		?>
         		@foreach($scenarios as $detail)
         		<tr>
         			<td> 
         				{{$i++}}        				
         			</td>
         			<td> 
         			<a href="{{URL::route('scenario.show', ['id' => $detail->tsc_id])}}">
         				{{$detail->tsc_name}}</a>     				
         			</td>
         			<td>  
         				{{($detail->description == "" ) ? "-" : $detail->description}}          				
         			</td>
         			<td> 
         				{{$detail->testcases}}
         			</td>
         			<td> 
         				{{$detail->created_by}} 
         			</td>
         			<td> 
         				{{date($small_dt_format, strtotime($detail->created_at))}} 
         			</td>	
                  <!--Lab for multiple scenarios - to be implemented  -->
                  <!-- <td> 
                   <input type="checkbox" id="{{$detail->tsc_id}}" name="{{$detail->tsc_id}}" class="checkbox">                 
                  </td> -->


         			<td> 
                  <a href="{{URL::route('scenario.show', ['id' => $detail->tsc_id])}}" style="margin-right: 10px"> <span id="" class="glyphicon glyphicon-eye-open"></span></a>	

                  <a href="{{URL::route('scenario.edit', ['id' => $detail->tsc_id])}}" style="margin-right: 10px"> <span id="" class="glyphicon glyphicon-pencil"></span></a> 

         			</td>
         		</tr>
         		@endforeach
         	</tbody>
         </table>
		
        </div>

</div>