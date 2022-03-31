@extends('layouts.main')
@section('content')
    <p>Thanh cong</p>
    <?php $user = session()->get('user'); ?>
    <p> Welcome: {{$user['email']}} </p>
    <form action="{{route('logout')}}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-primary" type="submit">Log out</button>
    </form>
@endsection