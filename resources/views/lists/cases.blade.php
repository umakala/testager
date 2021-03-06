
        <div class="panel-body" style="overflow-x: scroll">
          <div class="panel-title" style="font-weight: bold; padding-bottom: 10px;" > All Testcases </div>  

      <!--  Column details of test case to show 
      id, name, status(executed or not executed), executed type (manual/automation), executed by, executed date-time, checkpoint_result, execution_result(pass_fail), defect(if any), defect_status, (checkbox to select )
      -->
      <form action="{{URL::route('lab.create')}}" method="POST">
         <div class="panel-title" style="font-weight: bold; float: right; " > 
      
         </div>
         <input type="hidden" name="tsc_id" value="{{$id}}">
         <input type="hidden" name="type" value="case">


    <table  class="table table-striped table-hover" cellspacing="0" width="auto">
    <thead>
               <tr>
                  <th>#</th>
                  <th>Case Name</th>
                  <th>Description</th>
                  <th>Sequence No.</th>
               <th>
               <input type="checkbox" id="select_all" name="select_all" title="Select all" onclick="checkAll(this)" />   

               <button type="submit"  title="Select cases and Go to Testlab" > <span id="" class="glyphicon glyphicon-play-circle" ></span> Lab</button>
               </th>
               </tr>
            </thead>
            <tbody>
               <?php
                $i =1; 
               ?>
               @foreach($case_details as $detail)
               <tr>
                  <td> 
                     {{$detail->seq_no}}                    
                  </td>
                  <td> 
                  <a href="{{URL::route('testcase.show', ['id' => $detail->tc_id])}}"> <span id="" class="glyphicon glyphicon-eye-open"></span>
                     {{$detail->tc_name}}</a>               
                  </td>
                  <td style="max-width:200px">  
                     {{$detail->description}}                    
                  </td>
                 <td>  
                     {{$detail->seq_no}}                    
                  </td>
                  
                  <td> 
                   <input type="checkbox" id="{{$detail->tc_id}}" name="{{$detail->tc_id}}" class="checkbox">                 
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         </form>

<script type="text/javascript">
    $("#scTBL").DataTable({ responsive: true});
</script>