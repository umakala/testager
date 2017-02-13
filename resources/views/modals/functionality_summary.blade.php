
            @include('modals.functionality_summary')

       <div class="panel-body">
            <p  onclick="hideSummary()">
              <a data-toggle="collapse" data-parent="#panel" href="#summary_body" class="panel-toggle">
                <span class="glyphicon glyphicon-eye-open"  id="icontoggle"></span><span style="font-style: bold; font-size: 16px; padding: 5px;" >All Labs Summary</span>
              </a>
            </p>
          </div>
        <div id="summary_body" class="panel-collapse">
        <div class="panel-body" >
            <div class="row">
                <div  class="col-lg-12 col-sm-12" >   
                <table class="table table-striped" style="border: none; font-size: 12px; " cellspacing="0" width="auto">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th style="vertical-align: middle;">Functionality</th>
                            <th colspan="4" style="text-align: center;">Testlabs</th>
                            <th colspan="4" style="text-align: center;">Teststeps</th><!-- 
                            <th colspan="3" style="text-align: center;">Scenarios</th> -->
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="alert alert-info">Total</th>
                            <th class="alert alert-success">Pass</th>
                            <th class="alert alert-danger">Fail</th>
                            <th class="alert error"  style="font-size:10px;">Not <br/>executed</th>

                            <th class="alert alert-info">Total</th>
                            <th class="alert alert-success">Pass</th>
                            <th class="alert alert-danger">Fail</th>
                            <th class="alert error" style="font-size:10px;">Not <br/> executed</th>

                           <!-- <th class="alert alert-info">Total</th>
                            <th class="alert alert-success">Pass</th>
                            <th class="alert alert-danger">Fail</th> -->
                           
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                         $i =1;
                         $sum_total = 0; $sum_pass =0; $sum_fail=0; $sum_not_executed=0;
                         $sum_step_total = 0; $sum_step_pass =0; $sum_step_fail=0; $sum_step_not_executed=0;
                        
                        ?>
                        @foreach($project->functionalities as $fn)
                        <tr>
                            <td> 
                                {{$i++}}                        
                            </td>
                            <td> 
                                <a href="{{URL::route('lab_list.functionality', ['id' => $fn->tf_id])}}" title="All test Labs for {{$fn->tf_name}} "> 
                                {{$fn->tf_name}}                    
                                </a>
                            </td>
                            <td class="alert alert-info">
                              {{ isset($fn->testcases['total']) ? $fn->testcases['total'] : $fn->testcases['total']= 0 }}
                              <?php $sum_total += $fn->testcases['total']; ?>
                                
                            </td>
                            <td class="alert alert-success">
                               {{ isset($fn->testcases['pass']) ? $fn->testcases['pass'] : $fn->testcases['pass']= 0 }}
                                <?php $sum_pass += $fn->testcases['pass']; ?>     
                            </td>
                            <td class="alert alert-danger">
                               {{ isset($fn->testcases['fail']) ? $fn->testcases['fail'] :$fn->testcases['fail']= 0 }} 
                                <?php $sum_fail += $fn->testcases['fail']; ?>
                            </td>
                            <td class="alert alert-warning">
                               {{ isset($fn->testcases['not_executed']) ? $fn->testcases['not_executed'] :$fn->testcases['not_executed']= 0 }}              
                                <?php $sum_not_executed += $fn->testcases['not_executed']; ?>

                            </td>
                            <td class="alert alert-info">
                              {{ isset($fn->teststeps['total']) ? $fn->teststeps['total'] : $fn->teststeps['total']= 0 }}
                              <?php $sum_step_total += $fn->teststeps['total']; ?>
                                
                            </td>
                            <td class="alert alert-success">
                               {{ isset($fn->teststeps['pass']) ? $fn->teststeps['pass'] : $fn->teststeps['pass']= 0 }}
                                <?php $sum_step_pass += $fn->teststeps['pass']; ?>     
                            </td>
                            <td class="alert alert-danger">
                               {{ isset($fn->teststeps['fail']) ? $fn->teststeps['fail'] :$fn->teststeps['fail']= 0 }} 
                                <?php $sum_step_fail += $fn->teststeps['fail']; ?>
                            </td>
                            <td class="alert alert-warning">
                               {{ isset($fn->teststeps['not_executed']) ? $fn->teststeps['not_executed'] :$fn->teststeps['not_executed']= 0 }}              
                                <?php $sum_step_not_executed += $fn->teststeps['not_executed']; ?>

                            </td>
                        </tr>
                        @endforeach
                        <tr style="background-color: gray; color: white">
                            <td> 
                                                   
                            </td>
                            <td> 
                               TOTAL
                            </td>
                            <td>
                               {{$sum_total}}
                            </td>
                            <td >
                               {{$sum_pass}}                           
                            </td>
                            <td >
                               {{$sum_fail}}                              
                            </td>
                            <td >
                               {{$sum_not_executed}}                              
                            </td>
                            <td>
                              {{$sum_step_total}}
                            </td>
                            <td >
                               {{$sum_step_pass}}                           
                            </td>
                            <td>
                               {{$sum_step_fail}}                              
                            </td>
                            <td>
                               {{$sum_step_not_executed}}                              
                            </td>
                        </tr>
                    </tbody>
                 </table>
                </div>
            </div>
        </div>
      </div>