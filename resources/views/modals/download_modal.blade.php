<!-- Delete Modal Start-->
       <div id="downloadModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content" style="text-align: left">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Download Details </h4>
            </div> 
            <form action="{{URL::route('download.store', ['id' => $tc_ids])}}" method ="POST" class="form-horizontal">
            <input type="hidden"  value="{{$tc_ids}}"  name="tc_ids">

            <div class="modal-body">
                <div class="form-group">
                    <label for="release" class="control-label col-xs-4">Aurotun Location</label>  
                    <div class="col-xs-6">    
                    <?php $loc = session()->get('autorun_location'); ?>
                    <input type="text" class="form-control" value="{{$loc}}" id="autorun"  name="autorun" placeholder="">
                       <div class="help-line" id="autorun-help"></div>
                   </div>
                </div>
                <div class="form-group">
                    <label for="release" class="control-label col-xs-4">Release</label>  
                    <div class="col-xs-6">    
                    <input type="text" class="form-control" value="" id="release"  name="release" placeholder="Release Version">

                       <div class="help-line" id="release-help"></div>
                   </div>
                </div>
                <div class="form-group">
                    <label for="network_type" class="control-label col-xs-4">Network Type</label>  
                    <div class="col-xs-6">
                        <select class="form-control" name="network_type">
                          <option value="wifi">wifi</option>
                          <option value="2g">2g</option>
                          <option value="3g">3g</option>
                          <option value="4g">4g</option>                                
                      </select>                 
                       <div class="help-line" id="network-help"></div>
                   </div>
                </div>

                <div class="form-group">
                    <label for="os_version" class="control-label col-xs-4">Operating system</label>  
                    <div class="col-xs-6">
                        <select class="form-control" name="os_version">
                          <option value="android_6_0_1">Android 6.0.1</option>
                          <option value="android_5_0_1">Android 5.0.1</option>
                          <option value="android_4_0_1">Android 4.0.1</option>                             
                      </select>
                   </div>
                </div>

                <div class="form-group">
                    <label for="os_version" class="control-label col-xs-4">Device Name</label>  
                    <div class="col-xs-6">
                       <input type="text" class="form-control" value="" id="device_name"  name="device_name" placeholder="Eg: Nexus 5, Nexus 10, Galaxy S5 .. ">
                   </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-sm">
                    Yes <span data-dismiss="modal"></span>
                </button>         
                <button type="button" class="btn-sm" data-dismiss="modal">No</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal End -->