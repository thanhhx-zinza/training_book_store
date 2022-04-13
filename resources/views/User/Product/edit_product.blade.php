@extends('layouts.main')
@section('title', 'edit product')
@section('content')
<form action="{{route("product.update", $product->id)}}" method="POST" enctype="multipart/form-data">
    @method("PUT")
    @csrf
    <div class="form-group">
        <input type="hidden" name="id" value="{{$product->id}}">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" value="{{$product->name}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Price</label>
        <input type="number" name="price" class="form-control" value="{{$product->price}}">
        @error('price')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea name="description" id="" rows="3" class="form-control">{{$product->description}}</textarea>
        @error('description')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Image</label>
        <input type="file" name="image" class="form-control">
        @error('image')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-success" >update</button>
</form>
@endsection
