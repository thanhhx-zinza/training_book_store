@extends('layouts.main')
@section('content')
    <?php echo session('success') ? session('success') : "" ?>
    <?php $user = session()->get('user'); ?>
    <p> Welcome: {{$user['email']}} </p>
    <form action="{{route('logout')}}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-primary" type="submit">Log out</button>
    </form>
@endsection
