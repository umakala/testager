
@extends('layouts.app')

@section('content')
<form action="{{URL::route('functionality.store')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >

<div class="wrapper" style="">
       <div class="panel panel-default" style=" padding-top:20px">
         <div class="panel-title" style="text-align: center;">Functionality</div>
         <hr/>

         <div class="panel-body">
        @if(!session()->has('open_project'))
             <div class="alert alert-info">Please Select a Test Project first.</div>
        @else
        <div class="col-sm-12 col-lg-12">                          
                     
                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Functionality Name</label>
                    <div class="col-xs-8">            
                       <input type="text" class="form-control" value="" id="name"  name="name" placeholder="">
                       <div class="help-line" id="name-help"></div>
                   </div>
               </div>  
               <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Description</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="description"  rows="4" ></textarea>
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
    
            <div class="form-group">
              <button type="submit" id="loginButton" class="btn btn-primary" style="float:right;" >Create</button>
            </div>

           </div>
          @endif
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
