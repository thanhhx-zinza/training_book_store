@extends('layouts.main')
@section('title', 'edit store')
@section('content')
<form action="{{route('store.update', $store->id)}}" method="POST" enctype="multipart/form-data">
    @method("PUT")
    @csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name"class="form-control" value="{{$store->name}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" id="" rows="3" class="form-control">{{$store->description}}</textarea>
        @error('description')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Avatar</label>
        <input type="file" name="image" class="form-control">
        @error('image')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
</form>
@endsection
