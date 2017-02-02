<!-- Upload Modal Start-->
<div id="cloneModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="text-align: left">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Clone {{$clone_type}} </h4>
      </div> 
      <form action="{{URL::route($clone_type.'.clone')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >
        <div class="modal-body" style="padding-bottom: 10px">
          <div class="form-group"> 
            
              @if($clone_type == 'testcase')
              <label for="tc_id" class="control-label col-xs-2">{{$clone_type}}</label>
            <div class="col-xs-10"> 
              <select class="form-control" name="tc_id"  style=" "> 
                <option value="none">Select {{$clone_type}}</option>
                @foreach ($clone_case as $case)    
                <option value="{{$case->tc_id}}" title="{{$case->description}}" style= 'max-width: 100px;overflow: hidden;'> {{$case->tc_name}} -
                  {{substr($case->description, 0, 50).".."}}  </option>
                  @endforeach 
                </select>   
                <input type="hidden" name="tsc_id" value="{{$id}}">


                @elseif($clone_type == 'scenario')
                <label for="tc_id" class="control-label col-xs-2">{{$clone_type}}</label>
            <div class="col-xs-10"> 
                <select class="form-control" name="tsc_id"  style=" "> 
                  <option value="none">Select {{$clone_type}}</option>
                  @foreach ($clone_sc as $sc)    
                  <option value="{{$sc->tsc_id}}" title="{{$sc->description}}" style= 'max-width: 100px;overflow: hidden;'> {{$sc->tsc_name}} -
                    {{substr($sc->description, 0, 50).".."}}  </option>
                    @endforeach 
                  </select>   
                  <input type="hidden" name="tf_id" value="{{$id}}">

                  @elseif($clone_type == 'functionality')
                  <label for="tc_id" class="control-label col-xs-2">project</label>
            <div class="col-xs-10"> 
                  <select class="form-control" name="project" id="project" style=" " onchange="updateSelectChildren(this, '.tf' )"> 
                    <option value="none">All</option>
                    @foreach ($all_projects as $p)                            
                    <option value="{{$p->tp_id}}" title="{{$p->description}}" style= 'max-width: 100px;overflow: hidden;'> {{$p->tp_name}} -
                      {{substr($p->description, 0, 50).".."}}  </option>
                      <!-- <input type="hidden"  id="option_tp_id" name="option_tp_id" > -->
                      @endforeach 
                    </select>
                  </div>
                </div>
                <div class="form-group">
                    <label for="tc_id" class="control-label col-xs-2">{{$clone_type}}</label>
            <div class="col-xs-10"> 

                    <select class="form-control" name="tf_id" id="tf_id" style=" "> 
                      <option value="none">Select {{$clone_type}}</option>
                      @foreach ($clone_fn as $fn) 
                      <option class="tf" value="{{$fn->tf_id}}" title="{{$fn->description}}" style= 'max-width: 100px;overflow: hidden;'> {{$fn->tf_name}} -
                        {{substr($fn->description, 0, 50).".."}}  
                      </option>                            
                      @endforeach 
                    </select>

                    @foreach ($clone_fn as $fn) 
                    <input type="hidden" id="{{$fn->tf_id}}" value="{{$fn->tp_id}}"> 
                    @endforeach 

                    @endif

                    <div class="help-line" id="tsc-help"></div>
                  </div>
                </div>
                @if($clone_type == 'functionality')
                <div class="form-group">
                  <div class="col-xs-12" style="text-align: center"> 
                    <input type="checkbox" name="all_scenarios" id="all_scenarios" style="margin-right:5px; margin-bottom:0px;"  checked="true" /> <label for="ts_selection" class="control-">Clone all associated scenarios, testcases and teststeps</label>
                  </div>
                </div>

                @elseif($clone_type == 'scenario')
                <div class="form-group">
                  <div class="col-xs-12" style="text-align: center"> 
                    <input type="checkbox" name="all_testcases" id="all_testcases" style="margin-right:5px; margin-bottom:0px;"  checked="true" /> <label for="ts_selection" class="control-">Clone all associated testcases and teststeps</label>
                  </div>
                </div>
                @else
                <div class="form-group"> 
                  <div class="col-xs-12" style="text-align: center"> 
                    <input type="checkbox" name="all_teststeps" id="all_teststeps" style="margin-right:5px; margin-bottom:0px;"  checked="true" /> <label for="ts_selection" class="control-">Clone all associated teststeps</label>
                  </div>
                </div>
                @endif
              </div>
              <div class="modal-footer">
               <button type="submit" class="btn-sm">Clone</button>
               <button type="button" class="btn-sm" data-dismiss="modal">Cancel</button>
             </div>
           </form>
         </div>
       </div>
     </div>
     <!-- Upload Modal Ends-->
