
@extends('layouts.app')

@section('content')
<div class="wrapper" style="">
    <div class="col-sm-12 col-lg-12">
       <div class="panel panel-default" style=" padding-top:20px">
        <div class="panel-title" style="text-align: center;">Add New Project</div>
         <hr/>
         <div class="panel-body">
            <form action="{{URL::route('project.store')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >               
               <div class="form-group"> 

                    <label for="release" class="control-label col-xs-4">Release</label>  
                    <div class="col-xs-6">    
                    <input type="text" class="form-control" value="" id="release"  name="release" placeholder="*Release Version">
                       <div class="help-line" id="release-help"></div>
                   </div>
                </div>
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">*Project Name</label>
                    <div class="col-xs-6">            
                       <input type="text" class="form-control" value="" id="name"  name="name" placeholder="*Project Name">
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
                <div class="form-group"> 
                    <label for="package_name" class="control-label col-xs-4">Package Name</label>
                    <div class="col-xs-6">            
                       <input type="text" class="form-control" value="" id="package_name"  name="package_name" placeholder="(optional)">
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Activity Name</label>
                    <div class="col-xs-6">            
                       <input type="text" class="form-control" value="" id="activity_name"  name="activity_name" placeholder="(optional)">
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>
                <!-- <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">App wait Activity</label>
                    <div class="col-xs-6">            
                       <input type="text" class="form-control" value="" id="app_wait_name"  name="app_wait_name" placeholder="(optional)">
                       <div class="help-line" id="name-help"></div>
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
         <div class="form-group"> 
                    <span class="col-xs-4"></span>
                    <div class="col-xs-6">            
                        <button type="submit" id="loginButton" class="btn btn-primary" style="float:right" >Create</button>
                   </div>
               </div>
       
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
