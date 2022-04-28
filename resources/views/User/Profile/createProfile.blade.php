@extends('layouts.main')
@section('content')
<form action="{{route('profile.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" placeholder="enter your full name">
    </div>
    <div class="form-group">
        <label for="">FirstName</label>
        <input type="text" name="first_name" class="form-control" placeholder="enter your first name">
    </div>
    <div class="form-group">
        <label for="">LastName</label>
        <input type="text" name="last_name" class="form-control" placeholder="enter your last name">
    </div>
    <div class="form-group">
        <label for="">Date of birth</label>
        <input type="date" name="dob" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Phone</label>
        <input type="text" name="phone_number" class="form-control" placeholder="enter your phone number">
    </div>
    <div class="form-group">
        <label for="">gender</label>
        <select name="gender" id="">
            <option value="0">female</option>
            <option value="1">male</option>
        </select>
    </div>
    <div class="form-group">
        <label for="">Address</label>
        <input type="text" name="address" class="form-control" placeholder="enter your address">
    </div>
    <div class="form-group">
        <label for="">Avatar</label>
        <input type="file" name="avatar" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
