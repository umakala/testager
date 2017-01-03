
@extends('layouts.app')

@section('content')
<div class="wrapper" style="margin-top: -20px">

    <table id="newsTBL" class="table table-striped" cellspacing="0" width="auto">
        <tbody>
            <tr id="newsId_{{$item->news_id}}"> 
                <td style="width: 80%"> 
                    <table id="" class="table" cellspacing="5px" width="auto">
                        <tr>
                            <td >                            
                                <span style="font-size: large;" class="col-sm-9 col-lg-9">{{$item->title}}</span>
                                <span style="font-size: normal; text-align: right;" class="col-sm-3 col-lg-3"><a class="btn-sm" href="{{url('download/'.$item->news_id)}}"><img src="{{ URL::asset('assets/images/pdf-icon.png')}}" width="25px" height="28px"></a></span>
                            </td>
                        </tr>
                        <tr style="height: 20%">
                            <td>
                                <span style="font-size: smaller;" class="col-sm-6">{{$item->created_at}}</span>
                                <span style="font-size: smaller; text-align: right" class="col-sm-6">
                                   @if (session()->has('name'))
                                   <button type="button" class="btn-sm" data-toggle="modal" data-target="#myModal"> <i class="glyphicon glyphicon-trash"></i> Delete News </button>
                                   <!-- Delete Modal Start-->
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
                                            <a class="btn" href="{{url('news/delete/'.$item->news_id)}}">Yes</a>
                                            <button type="button" class="btn-sm" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Delete Modal End -->
                            @else
                            Reported By : <strong>{{$item->reporter_email}}</strong>
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        @if($item->image != "")
                        <span  class="col-sm-12" style="text-align: center;">
                          <img src="{{$item->image}}" class="img-responsive inline-block" width ='60%'>
                        </span>
                        @endif
                        <span class="col-sm-12" style="padding-top: 20px">
                        {{$item->text}}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</tbody>
</table>
</div>
@endsection
