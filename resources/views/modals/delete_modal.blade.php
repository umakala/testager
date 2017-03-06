<!-- Delete Modal Start-->
       <div id="deleteModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content" style="text-align: left">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span style="text-transform: uppercase;"><strong>{{$delete_type}}</strong></span> Deletion Confirmation </h4>
            </div> 
            <div class="modal-body">
                <h5>Are you sure you want to delete this <span style="text-transform: uppercase;">{{$delete_type}}</span>?</h5> 
            </div>
            <div class="modal-footer">
            <form action="{{URL::route($delete_type.'.destroy', ['id' => $id])}}" method ="POST" class="form-horizontal">

            @if($delete_type=='teststep')
             <div class="form-group">
                    <label for="network_type" class="control-label col-xs-4">Delete Level</label>  
                    <div class="col-xs-6">
                        <select class="form-control" name="delete_level">
                          <option value="step" >This TestStep</option>
                          <option value="case" >This Testcase</option>
                         <!--  <option value="scenario">This Scenario</option>
                          <option value="functionality">This Functionality</option>
                        -->   <option value="project">This Project</option>                                
                      </select>                 
                       <div class="help-line" id="network-help"></div>
                   </div>
                </div>
                @endif
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn-sm">
                    Yes
                </button>
         
                <button type="button" class="btn-sm" data-dismiss="modal">No</button>
                   </form>
            </div>

        </div>
    </div>
</div>
<!-- Delete Modal End -->