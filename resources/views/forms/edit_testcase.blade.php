
@extends('layouts.app')

@section('content')
<form action="{{URL::route('testcase.update', ['id' => $case->tc_id])}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >   
<input type="hidden" name="_method" value="PUT">
<div class="wrapper" style="">
      <div class="panel panel-default" style=" padding:20px">
         <div class="panel-title" style="text-align: center;">Update Testcase</div>
         <hr/>

        <div class="panel-body">
        <div class="col-sm-12 col-lg-6">                                      
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Testcase Name</label>
                    <div class="col-xs-8">            
                       <input type="text" class="form-control" value="{{$case->tc_name}}" id="name"  name="name" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
               
               <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="6" >{{$case->description}}</textarea>
                   <div class="help-line" id="text-help"></div>
               </div>
           </div>           
           
        </div>
        <div class="col-sm-12 col-lg-6">                
               <div class="form-group">                
                 <label for="expected_result" class="control-label col-xs-4">Expected Result</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="expected_result"  rows="6" >{{$case->expected_result}}</textarea>
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
