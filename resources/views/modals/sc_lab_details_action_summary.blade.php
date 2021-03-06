<!-- Action Box Starts -->
    <div class="panel panel-default">

     <div class="panel-title" style="padding: 0.25em 1% 0 1%;"> 

      <h4 style="display: inline-block;">
         Actions
      </h4>
       <p style="float:right;">

        <a  data-toggle="modal" data-target="#deleteModal" title="Delete Scenario Lab"> <i class="glyphicon glyphicon-trash"  ></i> Delete
        </a>               
      </p>

    <?php $delete_type="sc_lab" ; $id = $scenario->lab->scl_id; ?>
    @include('modals.delete_modal')
    </div>

    <div class="panel-body">
    @if($scenario->lab->result == '') 
      <div class="col-lg-6">
       <div class="row">
        <h4 style="font-style: bold;  padding: 5px;" >Manual Testing</h4>
      </div>
      <div class="row">
       <div class="col-lg-6">
        <a  title="Download Result format Sheet" href="{{URL::route('format_download', ['type' => 'scenario', 'id' => $scenario->lab->scl_id])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Result Format
        </a>  
      </div>
      <div class="col-lg-6">
       <a  data-toggle="modal" data-target="#uploadResultModal" title="Upload Results"> <i class="glyphicon glyphicon-upload"  ></i> Upload Manual Results
       </a> 
     </div>
   </div>
 </div>
 @endif

 <div class="col-lg-6">
  <div class="row">
    <h4 style="font-style: bold;  padding: 5px;" >Automation Testing</h4>
  </div>
  <div class="row" >
    <div class="col-lg-6">
     <a  title="Download Execute Sheet for AutoRun" href="{{URL::route('script_download', ['type' => 'scenario', 'id' => $scenario->lab->scl_id])}}"> <i class="glyphicon glyphicon-download"  ></i> Download Execution Script
     </a>
                  <!--     
             <a  data-toggle="modal" data-target="#downloadModal" title="Download Excel"> <i class="glyphicon glyphicon-cloud-download"  ></i> Download Execution Script
             </a>  -->   
           </div>
            <div class="col-lg-6">
            <a href="{{URL::route('execute.process', ['id' => $scenario->lab->scl_id])}}"> <span id="" class="glyphicon glyphicon-play-circle"></span> Execute on AutoRun</a>
          </div>
        </div>
      </div>
    </div>
</div>

@include('modals.upload_result_modal') 
<!-- Action Box Ends -->


<!-- Summary Box Starts -->


<div class="panel-body" style="padding-bottom: 0px;">

  <h4 style="float:left">
    Summary
  </h4>         
</div>

<div class="panel-body" style="padding-top: 0px;">

  <div class="row" > 
    <div  class="col-md-6 col-sm-12"  style="padding-top: 10px;">
    @if($scenario->lab->result == '')   
      <form action="{{URL::route('report.update', ['id' => $scenario->lab->scl_id])}}" method ="POST">
        <div class="row">                    
          <div  class="col-lg-2" >Result :
          </div>
          <div  class="col-lg-10" >

            <input type="hidden" name="_method" value="PUT"> 
            <input type="hidden" name="type" value="scenariolab">             

            <div class="alert 
            alert-{{$scenario->lab->result == 'Pass'? 'success' : 
            ($scenario->lab->result == 'Fail'? 'danger' : 
            ($scenario->lab->result == '' || $scenario->lab->result == 'not_executed' ? 'warning': 
            ($scenario->lab->result == 'none' ? 'error' : 'warning')))}}" style="padding:10px; "> 
            <select class="alert form-control" name="result" style="padding:5px; margin-bottom: 0px">
              <option value="Pass"  class="alert alert-success"
              {{ $scenario->lab->result == "Pass" ? 'selected' : ''}}>Pass</option>
              <option value="Fail" class="alert alert-danger"
              {{ $scenario->lab->result == "Fail" ?  'selected' : '' }}>Fail</option>
              <option value="" class="alert alert-warning"
              {{ $scenario->lab->result == ""  ?  'selected' : '' }}>Not Available</option>
              <option value="none" class="alert alert-error"
              {{ $scenario->lab->result == "none"  ?  'selected' : '' }}>Not Defined</option>
            </select>  
          </div>
        </div>
      </div>  

      <div class="row"> 

        <div  class="col-lg-2" >Comment :
        </div>
        <div  class="col-lg-8" style="padding-bottom: 5px">
         <textarea class="form-control"  name="comment" rows="3" style="resize: none;overflow-y: scroll;" >{{$scenario->lab->comment}}</textarea>
       </div>

       <button type="submit" title="Update result for this lab" name="" style="float: right;">Update Result</button>
     </div>
   </form>
   @else


        <div class="row"> 

                <div  class="col-lg-2" >Result :
                </div>
                <div  class="col-lg-8" style="padding-bottom: 5px">
                  <div class="alert 
                        alert-{{$scenario->lab->result == 'Pass'? 'success' : 
                                ($scenario->lab->result == 'Fail'? 'danger' : 
                                ($scenario->lab->result == '' || $scenario->lab->result == 'not_executed' ? 'warning': 
                                ($scenario->lab->result == 'none' ? 'error' : 'warning')))}}" style="padding:10px; "> 
                                {{$scenario->lab->result}}

                  </div>
                </div>           
        </div>
        <div class="row"> 

                <div  class="col-lg-2" >Comment :
                </div>
                <div  class="col-lg-8" style="padding-bottom: 5px">
                 {{($scenario->lab->comment == "" )? "NA" : $scenario->lab->comment}}  
                </div>           
        </div>
   @endif
    
 </div>
 <div>
 </div>
<div  class="col-md-1"></div>
  <div  class="col-md-4 col-sm-12 panel panel-default"  style="padding: 2%;">
    <div class="row">                    
      <div  class="col-lg-6" >Execution Type :
      </div>
      <div  class="col-lg-6" ><strong>{{($labs[0]->execution_type=="")?"NA":$labs[0]->execution_type}}</strong>
      </div>
    </div>

    <?php $release = explode('/', $labs[0]->release_version);
     ?>
    <div class="row">                    
      <div  class="col-lg-6" >Release :
      </div>
      <div  class="col-lg-6" ><strong>{{$release[0]}}</strong>
      </div>
    </div>
    <div class="row">                    
      <div  class="col-lg-6" >Cycle :
      </div>
      <div  class="col-lg-6" ><strong>{{isset($release[1])? $release[1] : "NA"}}</strong>
      </div>
    </div>
    <div class="row">                    
      <div  class="col-lg-6" >Network :
      </div>
      <div  class="col-lg-6" ><strong>{{$labs[0]->network_type}}</strong>
      </div>
    </div>                        
    <div class="row">                    
      <div  class="col-lg-6" >OS : 
      </div>
      <div  class="col-lg-6" ><strong>{{$labs[0]->os_version}}</strong>
      </div>
    </div>

    <div class="row">                    
      <div  class="col-lg-6" >Device :
      </div>
      <div  class="col-lg-6" ><strong>{{$labs[0]->device_name}}</strong>
      </div>
    </div>
    <div class="row">
        <div  class="col-lg-6" >No. of Testcases :
        </div>
        <div  class="col-lg-6" style="padding-bottom: 5px">
         <strong>{{count($labs)}}  </strong>
        </div>           
    </div>
  </div>                            
</div>
</div>
<hr/>

<!-- Summary Box Ends -->