
@extends('layouts.app')

@section('content')
<div class="wrapper" style="">
    <div class="col-sm-12 col-lg-12">
       <div class="panel panel-default" style=" padding-top:20px">
        <div class="panel-title" style="text-align: center;">Upload Management</div>
         <hr/>
         <div class="panel-body">
            <form action="{{URL::route('upload.store')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >               
               <div class="form-group"> 
                    <label for="title" class="control-label col-xs-4">Release</label>   
                    <div class="col-xs-8"> 
                    <input type="text" class="form-control" value="" id="release"  name="release" placeholder="*Release Version">
                       <div class="help-line" id="release-help"></div>
                   </div>                   
                </div>
                
                <div class="form-group">
                  <label class="control-label col-xs-4"> Upload File</label>
                  <div class="col-xs-8">
                      <div class="rowPanel" style="margin-top: 16px; text-align:center;">
                        <input id="image" type="file" name="file">
                      </div>
                  </div>
                </div>

                
                                   
                      <!-- Upload Modal Start-->
                      <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content" style="text-align: left">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Deletion Confirmation </h4>
                                </div> 
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this news article?</p>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn" href="#">Yes</a>
                                    <button type="button" class="btn-sm" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Upload Modal Ends-->              

                             
                         
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
        <button type="submit" id="loginButton" class="btn btn-primary" style="float:right" >Upload</button>
    </form>
</div>
</div>
</div>
</div>

@endsection
