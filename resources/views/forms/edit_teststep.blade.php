
@extends('layouts.app')


@section('delete_modal')
  <?php $delete_type = 'teststep'; $id = $step->ts_id ;?>
    @include('modals.delete_modal')
@endsection

@section('content')
<form action="{{URL::route('teststep.update', ['id' => $step->ts_id])}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >   
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="tc_id" value="{{$step->tc_id}}">

<div class="wrapper" style="">
      <div class="panel panel-default" style=" padding:20px">
         <div class="panel-title" style="text-align: center;">Update Teststep</div>

         <hr/>
        

        <a style="float:right; padding-top:10px" data-toggle="modal" data-target="#deleteModal" title="Delete Testcase"> <i class="glyphicon glyphicon-trash"  ></i>Delete
        </a>

         <ol class="breadcrumb">
          <li><a href="{{URL::route('testcase.show' , ['id' => $step->tc_id] )}}">{{$step->tc_name}}</a></li>
          <li class="active">  <a href="{{URL::route('teststep.show' , ['id' => $step->ts_id] )}}">Teststep</a></li>
        </ol>

         <div class="panel-body">      
        <div class="col-sm-12 col-lg-6">                                      
               <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="6" >{{$step->description}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div>
           </div>
          </div>

            <div class="col-sm-12 col-lg-6">                
               <div class="form-group">                
                 <label for="expected_result" class="control-label col-xs-4">Expected Result</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="expected_result"  rows="6" >{{$step->expected_result}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div>         
              </div>
              </div>


  <div class="panel-title" style="text-align: center; padding-bottom:15px">Execution Format Details</div>
     
           <div class="col-sm-12 col-lg-6">  
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Scroll</label>
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
                          <option value="No" {{($execution->screenshot == "No")? 'selected' : '' }}>No</option>
                          <option value="Yes" {{($execution->screenshot == "Yes")? 'selected' : '' }} >Yes</option>
                      </select>
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
        
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Send key</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->sendkey}}" id="sendkey"  name="sendkey" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Checkpoint Value</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->checkpoint}}" id="checkpoint"  name="checkpoint" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Wait</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->wait}}" id="wait"  name="wait" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>

          
          </div>

          <div class="col-sm-12 col-lg-6">  
          
          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Index</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->index}}" id="index"  name="index" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>

          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Text</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->text}}" id="text"  name="text" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>


          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Resource-ID</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->resource_id}}" id="resource_id"  name="resource_id" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>

           <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Class</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->class}}" id="class"  name="class" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
          </div>

          <div class="form-group"> 
                    <label for="title" class="control-label col-xs-3">Content-desc</label>
                    <div class="col-xs-9">            
                       <input type="text" class="form-control" value="{{$execution->content_desc}}" id="content_desc"  name="content_desc" placeholder="">
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

          <div class="form-group">
              <label for="network_type" class="control-label col-xs-4">Update Level</label>  
              <div class="col-xs-6">
                  <select class="form-control" name="update_level">
                    <option value="step" >This TestStep</option>
                    <option value="case" >This Testcase</option>
                    <option value="project">This Project</option>                                
                </select>                 
                 <div class="help-line" id="network-help"></div>
             </div>
          </div>
        <button type="submit" id="loginButton" class="btn btn-primary" style="float:right" >Update</button>
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
