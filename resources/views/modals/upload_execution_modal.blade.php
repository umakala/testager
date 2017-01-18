<!-- Upload Modal Start-->
<div id="uploadModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="text-align: left">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Upload Project Manager </h4>
          </div> 
          <form action="{{URL::route('upload.store')}}" method ="POST" class="form-horizontal" enctype='multipart/form-data' >
          <div class="modal-body" style="padding-bottom: 10px">
              <div class="form-group" >
               <div class="col-xs-12"> 
                <div class="input-group">
                  <label class="input-group-btn">
                      <span class="btn btn-default">
                          Browse <input type="file" style="display: none;" multiple="false" name = "file">
                          <input type="hidden" name="call_page" value="{{$call_teststep_page}}">
                          <input type="hidden" name="id" value="{{$id}}">
                      </span>
                  </label>
                  <input type="text" class="form-control" readonly="">
                </div>
              </div>
              </div>
              <div class="form-group" style="padding-top: 10px">
             <div class="col-xs-12">
                <p><i>Please make sure:</i></p>
               <ul class="alert alert-info" style="list-style: none">
                  <li>*Only 1 sheet is there in excel file.</li>
                  <li>*NO empty rows/columns should be in beginning of excel file.</li>
                  <li>There are no merged cells</li>
               </ul> 
               </div>
              </div> 



          </div>
          <div class="modal-footer">
               <button type="submit" class="btn-sm">Upload</button>
              <button type="button" class="btn-sm" data-dismiss="modal">Cancel</button>
          </div>
          </form>
      </div>
  </div>
</div>
<!-- Upload Modal Ends-->
