<!-- modal -->
    <div class="modal fade" id="new_village" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                	<form action="{{route('admin.lga.district.town.create',[admin()->state->name,$district->lga->name,$district->name])}}" method="post">
                		@csrf
                        <input type="hidden" name="district_id" value="{{$district->id}}">
                		<input type="text" name="town" value="{{old('town')}}" placeholder="Town or Village Name" class="form-control"><br>
                		<button class="btn btn-info">Register</button>
                	</form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- end modal -->