
@extends('layouts.app')

@section('content')
<div class="wrapper" style="">
    <div class="col-sm-12 col-lg-9">
       <div class="panel panel-default" style=" padding:20px">
        <div class="panel-title" >Create News Article</div>
        <hr/>        
        <div class="panel-body">
            <form action="{{URL::route('news.store')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >

                <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">News Title</label>
                    <div class="col-xs-8">            
                       <input type="text" class="form-control" value="" id="title"  name="title" placeholder="">
                       <div class="help-line" id="title-help"></div>
                   </div>
               </div>
               <div class="form-group">                
                 <label for="title" class="control-label col-xs-4">Text</label>
                 <div class="col-xs-8">            
                   <textarea class="form-control"  name="text"  rows="6" ></textarea>
                   <div class="help-line" id="text-help"></div>
               </div>

               <div class="form-group">
                <label class="control-label col-xs-4"> News Image</label>
                <div class="col-xs-8">
                 <div class="rowPanel" style="margin-top: 16px; text-align:center;">
                    <ul class="columnContainer">
                        <li>    
                            <div id="newsImageBG" class="fileinput-button imagePlaceholder">
                                <span style="vertical-align: middle; height: inherit;">  
                                  <img id="displayImg" src="" alt="" class="uploadImgDisplay" />
                              
                                    <span class="glyphicon glyphicon-camera"></span>
                                    <br/>
                                    <span style="font-size: 12px;">News Image</span>
                                    <input id="image" type="file" name="file"  onchange="readURL(this);">
                                     
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
                </div>
                </div>


           </div>           
           <div class="form-group">
            @if(isset($message))                           
            <div class="alert alert-danger">
                <ul>
                    @foreach ($message as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <button type="submit" id="loginButton" class="btn btn-primary" >Create</button>
    </form>
</div>
</div>
</div>
</div>

<script type="text/javascript">
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
</script>

@endsection
