@extends('layouts.main')
@section('content')
    <p> Welcome: {{$user->email}} </p>
    @if (!$user->store)
        <a href="{{route('store.create')}}" class="btn btn-success">Create store</a>
    @else
        <a href="{{route('store.show', $user->store->id)}}" class="btn btn-primary">store</a>
    @endif
    <form action="{{route('logout')}}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-danger" type="submit">Log out</button>
    </form>
    <a href="/stripe">Vip</a>
    <p>list store</p>
        <ul>
            @foreach ($stores as $store)
            <li><a href="{{route('store.show',$store->id)}}">{{$store->name}}</a></li>
            @endforeach
        </ul>
@endsection
