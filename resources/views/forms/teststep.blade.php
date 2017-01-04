
@extends('layouts.app')

@section('content')
  <form action="{{URL::route('teststep.store')}}" method ="POST" class="form-horizontal" >   

<div class="wrapper" style="">
      <div class="panel panel-default" style=" padding-top:10px">
         <div class="panel-title" style="text-align: center;">Test Step</div>
         <hr/>
         <div class="panel-body">
      @if(count($cases) == 0)
         <div class="alert alert-info">Please Create a Case first.</div>
      @else

      <div class="row">
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Step</th>
                    <th>Testcase</th>
                    <th>Description(Click/input/select)</th>
                    <th>Execution Format</th>
                    <th>Expected Result</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-sm-1">
                      Step 1
                    </td>
                    <td class="col-sm-1">
                      {{$cases[0]->tc_name}}
                      <input type="hidden"  value="{{$cases[0]->tc_id}}" name="tc_id"/>                     
                    </td>
                    <td class="col-sm-3">

                   <textarea class="form-control"  name="description"  rows="3" >{{old('description')}}</textarea>
                    </td>
                    <td class="col-sm-3">
                   <textarea class="form-control"  name="execution_format"  rows="3" >{{old('execution_format')}}</textarea>
                    </td>
                    <td class="col-sm-2">                    
                   <textarea class="form-control"  name="expected_result"  rows="3" >{{old('expected_result')}}</textarea>
                    </td>

                    <td class="col-sm-1">                                 
                       <select class="form-control" name="status">
                              <option value="not_executed">Not Executed</option>
                              <option value="pass">Pass</option>
                              <option value="fail">Fail</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
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
