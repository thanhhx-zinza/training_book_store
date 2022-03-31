@extends('layouts.main')
@section('content')
    <p>Thanh cong</p>
    <?php $user = session()->get('user'); ?>
    <p> Welcome: {{$user['email']}} </p>
    <a href="/logout" class="btn btn-primary">Log out</a>
@endsection