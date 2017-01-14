<!-- Delete Modal Start-->
       <div id="deleteModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content" style="text-align: left">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Deletion Confirmation </h4>
            </div> 
            <div class="modal-body">
                <h5>Are you sure you want to delete this {{$delete_type}}?</h5>
            </div>
            <div class="modal-footer">
            <form action="{{URL::route($delete_type.'.destroy', ['id' => $id])}}" method ="POST" class="form-horizontal">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn-sm">
                    Yes
                </button>
         
                <button type="button" class="btn-sm" data-dismiss="modal">No</button>
                   </form>
            </div>

        </div>
    </div>
</div>
<!-- Delete Modal End -->