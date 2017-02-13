<!-- Delete Modal Start-->
        <div class="panel panel-default" style=" padding-top:20px">
            <form action="{{URL::route('lab.store', ['id' => $tc_ids])}}" method ="POST" class="form-horizontal">
            <input type="hidden"  value="{{$tc_ids}}"  name="tc_ids">
            <input type="hidden"  value="{{$scenario->tsc_id}}"  name="tsc_id">

               <div class="panel-title row" style="text-align: center;">
                 <div class="col-xs-6">
                  <h4 >Lab Details </h4>                 
                 </div>
                  <div class="col-xs-6">
                      <h4>
                     <button type="submit" class="btn-md" style="padding: 5px" >
                      Create  Test Lab
                    </button>
                    </h4>
                  </div>
              </div>           
            <div class="panel-body">
               <!--  <div class="form-group">
                    <label for="release" class="control-label col-xs-4">Autorun Location</label>  
                    <div class="col-xs-6">    
                    <?php $loc = session()->get('autorun_location'); ?>
                    <input type="text" class="form-control" value="{{$loc}}" id="autorun"  name="autorun" placeholder="">
                       <div class="help-line" id="autorun-help"></div>
                   </div>
                </div> -->
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
                          <option value="Android 7.0.1">Android 7.0.1</option>
                          <option value="Android 6.0.1">Android 6.0.1</option>
                          <option value="Android 5.0.1">Android 5.0.1</option>
                          <option value="Android 4.0.1">Android 4.0.1</option>
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
            </form>
        </div>
<!-- Delete Modal End -->