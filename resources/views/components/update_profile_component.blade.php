
  <!-- Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
          <button type="button" class="close  btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('profile.update', $user->profile ? $user->profile->id : "")}}" method="post" id="updateProfile" name="updateProfile" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('components.partials.form')
                <div class="form-group">
                    <label for="">Avatar</label>
                    <input type="file" name="avatar" id="avatar" class="form-control" >
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="update" class="btn btn-primary">update</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
