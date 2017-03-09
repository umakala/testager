
         <div class="panel-body"  id ="top">
           <div class="panel-title" style="padding-bottom: 10px;" > Testcase Details 
             <p  onclick="hideSummary()" style="float:right">
              <a data-toggle="collapse" data-parent="#panel" href="#summary_body" class="panel-toggle">
                <span class="glyphicon glyphicon-filter"  id="icontoggle"></span><span style="font-style: bold; font-size: 14px; padding: 5px;" >Filters</span>
              </a>
            </p>
            <p  style="float:right">
              <a href="{{URL::route('sc_report.index')}}" style="font-size: 14px; padding: 5px;">All Scenario Labs Report
              </a><a href="{{URL::route('report.index')}}" >
              <span class="glyphicon glyphicon-show"  id="icontoggle"></span><span style="font-size: 14px; padding: 5px;" >All Test Labs Report</span>
            </a>
          </p>

        </div>
        
        <div id="summary_body" class="panel-collapse collapse"  >
          <div class="panel-body" style="font-size:12px">        
            <div class="row">
              <div class="col-lg-6">
                   <!--  <form action="{{URL::route('download.store', ['id' => ''])}}" method ="POST" class="">
                        <div class="form-group">
                            <label for="os_version" class="control-label col-xs-4">Filter by Functionality</label>
                            <div class="col-xs-6">
                                <select class="form-control" name="os_version"  style="font-size:12px">
                                    @foreach($project->functionalities as $fn)
                                        <option value="{{$fn->tf_id}}">{{$fn->tf_name}}</option>
                                    @endforeach
                              </select>
                           </div>
                        </div>
                      </form> -->

                    </div>
                  </div>
                </div>
              </div>
            </div>