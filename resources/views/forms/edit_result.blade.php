
@extends('layouts.app')

@section('content')
<div class="wrapper" style="">
    <div class="col-sm-12 col-lg-12">
       <div class="panel panel-default" style=" padding-top:20px">
        <div class="panel-title" style="text-align: center;"> Lab for : {{$lab->tc_name}}</div>
         <hr/>
         <div class="panel-body">
            <form action="{{URL::route('report.update', ['id' => $lab->tl_id])}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' > 
              <input type="hidden" name="_method" value="PUT"> 
              <input type="hidden" name="type" value="testlab">              
              
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">lab for case</label>
                    <div class="col-xs-8">            
                       <label  class="form-control" name="name">{{$lab->tc_name}}</label>
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
              <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Execution Result</label>
                    <div class="col-xs-8">
                    <select class="form-control" name="execution_result">
                      <option value="Pass" 
                          {{ $lab->execution_result == "Pass" ? 'selected' : ''}}>Pass</option>
                      <option value="Fail" 
                          {{ $lab->execution_result == "Fail" ?  'selected' : '' }}>Fail</option>
                      <option value="" 
                          {{ $lab->execution_result == "" || $lab->execution_result == "none"  ?  'selected' : '' }}>Not Available</option>
                    </select>
                   </div>
               </div>

               <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Checkpoint Result</label>
                    <div class="col-xs-8">  
                    <select class="form-control" name="checkpoint_result">
                      <option value="Pass" 
                          {{ $lab->checkpoint_result == "Pass" ? 'selected' : ''}}>Pass</option>
                      <option value="Fail" 
                          {{ $lab->checkpoint_result == "Fail" ?  'selected' : '' }}>Fail</option>
                      <option value="" 
                          {{ $lab->checkpoint_result == ""  ?  'selected' : '' }}>Not Available</option>
                      <option value="" 
                          {{ $lab->checkpoint_result == "none"  ?  'selected' : '' }}>Not Defined</option>
                          </select>     
                   </div>
               </div>

               <!-- <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="4" >{{$lab->description}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div> 
              </div> -->
                     
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
        <button type="submit" id="loginButton" class="btn btn-primary" style="float:right" >Update</button>
    </form>
</div>
</div>
</div>
</div>

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
