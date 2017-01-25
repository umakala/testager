
@extends('layouts.app')

@section('content')
  <form action="{{URL::route('teststep.store')}}" method ="POST" class="form-horizontal" >   

<div class="wrapper" style="">
      <div class="panel panel-default" style=" padding-top:10px">
         <div class="panel-title" style="text-align: center;">Add New Teststep</div>
         <hr/>
         <div class="panel-body">
      @if(count($cases) == 0)
         <div class="alert alert-info">Please Create a Case first.</div>
      @else

       <ol class="breadcrumb">
          <li><a href="{{URL::route('testcase.show' , ['id' => $cases[0]->tc_id] )}}">  {{$cases[0]->tc_name}}</a></li>
          <li class="active">Teststep</li>
        </ol>
        <input type="hidden"  value="{{$cases[0]->tc_id}}" name="tc_id"/>

         <div class="panel-body">      
        <div class="col-sm-12 col-lg-6">                                      
               <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="6" >{{old('description')}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div>
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
              </div>

    
    <div class="panel-title" style="text-align: center; padding-bottom:15px">Execution Format Details</div>
     
           <div class="col-sm-12 col-lg-6">  
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Options</label>
                    <div class="col-xs-9">            
                      <select class="form-control" name="scroll">
                          <option value="No" selected>Scroll No</option>
                          <option value="Yes">Scroll Yes</option>   
                          <option value="Back" >Back Button</option>                      
                          <option value="tap" >Tap</option>                      
                          <option value="otp" >OTP</option> 
                      </select>
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Screenshot</label>
                    <div class="col-xs-9">            
                      <select class="form-control" name="screenshot">
                          <option value="No" selected>No</option>
                          <option value="Yes">Yes</option>
                      </select>
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
        
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Send key</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="Click" id="sendkeys"  name="sendkeys" placeholder="Click">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Checkpoint Value</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('checkpoint')}}" id="checkpoint"  name="checkpoint" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Wait</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('wait')}}" id="wait"  name="wait" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>

          
          </div>

           <div class="col-sm-12 col-lg-6">  
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Resource-ID</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('resource_id')}}" id="resource_id"  name="resource_id" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
            <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Content-desc</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('content_desc')}}" id="content_desc"  name="content_desc" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
           <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Class</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('class')}}" id="class"  name="class" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
           
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Text</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('text')}}" id="text"  name="text" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
           <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Index</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{old('index')}}" id="index"  name="index" placeholder="">
                       <div class="help-line" id="name-help"></div>
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
        <button type="submit" id="loginButton" class="btn btn-primary" style="float:right" >Add Step</button>
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
