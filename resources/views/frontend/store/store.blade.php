@extends('layouts.main')
@section('title', 'cua hang')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="auth" style="float: right">
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </div>
    </div>
</div>
<p>Danh sach cua hang</p>
<ul>
    @foreach ($stores as $store)
    <li><a href="{{route('store_detail',$store->id)}}">{{$store->name}}</a></li>
    @endforeach
</ul>
@endsection
