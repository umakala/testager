<div class="panel-body" style="padding-top: 0px"> 
      <h4 style="display: block;">
       Testcase labs
     </h4>
     
      <table id="scTBL" class="table table-striped table-hover" cellspacing="0" width="auto">
       <thead>
       <tr>
        <th>#</th>
        <th>Case Name</th>
        <th>Description</th>
        <th>Steps</th>
        <th>Expected Results</th>         
      </tr>
    </thead>
    <tbody>
     <?php
     $i =0; 
     ?>
     @foreach($labs as $scenario->lab)
     <tr>
      <td> 
       {{++$i}}               
     </td>
     <td> 
      <!-- <a href="{{URL::route('report.lab', ['id' => $scenario->lab->tl_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span> -->
      {{$scenario->lab->case->tc_name}}
    </td>
    <td>  
     {{$scenario->lab->case->description}}                  
   </td>
   <td>  
   
    @foreach($scenario->lab->case->steps as $step)
      {{$step->description}} <br/>  
    @endforeach
   </td>
   <td> 
     {{$scenario->lab->case->expected_result}}                  

   </td>
 </tr>
@endforeach

</tbody>
</table>
</div>
</div>

<script type="text/javascript">
    $("#scTBL").DataTable({ responsive: true});
</script>