
@extends('layouts.app')

@section('content')
  <form action="{{URL::route('teststep.store')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >   

<div class="wrapper" style="">
      <div class="panel panel-default" style=" padding:20px">
         <div class="panel-title" style="text-align: center;">Test Step</div>
         <hr/>
         <div class="panel-body">
      @if(count($cases) == 0)
         <div class="alert alert-info">Please Create a Case first.</div>
      @else
        <div class="col-sm-12 col-lg-6">  
                <div class="form-group"> 
                    <label for="tsc_id" class="control-label col-xs-4">Testcase</label>
                    <div class="col-xs-8">           
                       <select class="form-control" name="tc_id">
                          <option value="none">Select Testcase</option>
                          @foreach ($cases as $case)    
                              <option value="{{$case->tc_id}}"

                              >{{$case->tc_name}}</option>
                          @endforeach     
                      </select>   
                       <div class="help-line" id="tsc-help"></div>
                   </div>
               </div>            
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Teststep Name</label>
                    <div class="col-xs-8">            
                       <input type="text" class="form-control" value="{{old('name')}}" id="name"  name="name" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
                <div class="form-group"> 
                    <label for="status" class="control-label col-xs-4">Status</label>
                    <div class="col-xs-8">            
                       <select class="form-control" name="status">
                              <option value="not_executed">Not Executed</option>
                              <option value="pass">Pass</option>
                              <option value="fail">Fail</option>
                        </select>
                       <div class="help-line" id="status-help"></div>
                   </div>
               </div> 
               <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="6" >{{old('description')}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div>
           </div>           
           <div class="form-group">
            @if(isset($_GET['message']))                           
            <div class="alert alert-danger">
                <ul>
                    @foreach ($_GET['message'] as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
          </div>
          </div>
              <div class="col-sm-12 col-lg-6">
               <div class="form-group">                
                 <label for="expected_result" class="control-label col-xs-4">Expected Result</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="expected_result"  rows="6" >{{old('expected_result')}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div>
         
           </div>




        <button type="submit" id="loginButton" class="btn btn-primary" style="float:right" >Create</button>
 @endif
</div>
</div>
</div>
</div>

 </form>
<!-- <script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#ajaxLoader').show();
            $('#displayImg')
                // .on('load',imgLoaded("{{ URL::asset('assets/images/ajax-loader.gif')}}"))
                .attr('src', e.target.result)
                .width(300)
                .height(200);
            $('#iconDisplay').hide();
            $('#iconText').hide();
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script> -->

@endsection
