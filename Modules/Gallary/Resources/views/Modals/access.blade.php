

<!-- modal -->
<div class="modal fade" id="access_{{$album->id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form method="post" action="gallary/album/{{$album->albumContentType->name}}/grant-access" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="album_id" value="{{$album->id}}">
                <select name="accessor" class="form-control">
                	<option value="">Select Accessor</option>
                	<option value="user">User</option>
                	<option value="family">Family</option>
                </select>
                <input type="email" name="email" class="form-control" placeholder="User Email">
                <br>
                <button class="btn btn-primary">Grant {{$album->albumContentType->name}} Album Access</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- end modal -->