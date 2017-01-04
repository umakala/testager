
@extends('layouts.app')

@section('content')
<div class="wrapper" style="">
    <div class="col-sm-12 col-lg-12">
       <div class="panel panel-default" style=" padding-top:20px">
        <div class="panel-title" style="text-align: center;"> Project : {{$project->tp_name}}</div>
         <hr/>
         <div class="panel-body">
            <form action="{{URL::route('project.update', ['id' => $project->tp_id])}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' > 
              <input type="hidden" name="_method" value="PUT">              
               <div class="form-group">  
                       <label for="title" class="control-label col-xs-4">Release</label> 
                    <div class="col-xs-8">
                       <input type="text" class="form-control" value="{{$project->release}}" id="release"  name="release" placeholder="Release">
                       <div class="help-line" id="release-help"></div>
                   </div>
                </div>
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Project Name</label>
                    <div class="col-xs-8">            
                       <input type="text" class="form-control" value="{{$project->tp_name}}" id="name"  name="name" placeholder="" >
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
               <!-- <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="4" >{{$project->description}}</textarea>
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
