@extends('layouts.main')
@section("title", "register")
@section('content')
    <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            <div id="emailHelp" class="form-text">
                @error('email')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            <div id="emailHelp" class="form-text">
                @error('password')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
