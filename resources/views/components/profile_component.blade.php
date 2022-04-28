
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
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->profile ? $user->profile->name : ""}}" readonly>
                </div>
                <div class="form-group">
                    <label for="">FirstName</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{$user->profile ? $user->profile->first_name : ""}}" readonly>
                </div>
                <div class="form-group">
                    <label for="">LastName</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{$user->profile ? $user->profile->last_name : ""}}" readonly>
                </div>
                <div class="form-group">
                    <label for="">Date of birth</label>
                    <input type="text" name="dob" id="dob" class="form-control" value="{{$user->profile ? $user->profile->dob : ""}}" readonly>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="phone_number" id="phone" class="form-control" value="{{$user->profile ? $user->profile->phone_number : ""}}" readonly>
                </div>
                <div class="form-group">
                    <label for="">gender</label>
                    <select name="gender" id="gender">
                        <option value="0"  {{$user->profile ? $user->profile->gender == "female" ? 'selected' : "" : ""}}>female</option>
                        <option value="1" {{$user->profile ? $user->profile->gender == "male" ? 'selected' : "" : ""}}  >male</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{$user->profile ? $user->profile->address : ""}}" readonly>
                </div>
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
