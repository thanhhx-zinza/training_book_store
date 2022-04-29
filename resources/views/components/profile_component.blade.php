
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
          <button type="button" class="close  btn btn-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="" enctype="multipart/form-data" id="profile-form">
                @csrf
                @include('components.partials.form')
                <div class="form-group">
                    <label for="">Avatar</label>
                    <img src="{{Storage::disk('public')->url($user->profile ? $user->profile->avatar : "")}}" alt="" class="w-25 h-25">
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
            edit
          </button>
        </div>
    </form>
      </div>
    </div>
  </div>
