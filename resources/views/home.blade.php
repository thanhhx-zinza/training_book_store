@extends('layouts.main')
@section('content')
    <p> Welcome: {{$user->email}} </p>
    @if (!$user->store)
        <a href="{{route('store.create')}}" class="btn btn-success">Tao cua hang</a>
    @else
        <a href="{{route('store.show', $user->store->id)}}" class="btn btn-primary">Cua hang</a>
    @endif
    <form action="{{route('logout')}}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-danger" type="submit">Log out</button>
    </form>
    <p>Danh sach cua hang</p>
        <ul>
            @foreach ($stores as $store)
            <li><a href="{{route('store.show',$store->id)}}">{{$store->name}}</a></li>
            @endforeach
        </ul>
@endsection
