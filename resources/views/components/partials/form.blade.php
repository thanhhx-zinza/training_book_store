<div class="form-group">
    <label for="">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $user->profile ? $user->profile->name : ""}}">
</div>
<div class="form-group">
    <label for="">FirstName</label>
    <input type="text" name="first_name" id="first_name" class="form-control" value="{{$user->profile ? $user->profile->first_name : ""}}">
</div>
<div class="form-group">
    <label for="">LastName</label>
    <input type="text" name="last_name" id="last_name" class="form-control" value="{{$user->profile ? $user->profile->last_name : ""}}">
</div>
<div class="form-group">
    <label for="">Date of birth</label>
    <input type="text" name="dob" id="dob" class="form-control" value="{{$user->profile ? $user->profile->dob : ""}}">
</div>
<div class="form-group">
    <label for="">Phone</label>
    <input type="text" name="phone_number" id="phone" class="form-control" value="{{$user->profile ? $user->profile->phone_number : ""}}">
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
    <input type="text" name="address" id="address" class="form-control" value="{{$user->profile ? $user->profile->address : ""}}">
</div>
