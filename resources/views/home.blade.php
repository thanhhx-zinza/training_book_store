@extends('layouts.main')
@section('content')
    <p> Welcome: {{$user->email}} </p>

    @if ($user)
    <!-- Button trigger modal -->
    <div>
        <img class="thumbnail img-responsive" src="{{Storage::disk('public')->url($user->profile ? $user->profile->avatar : "")}}" alt="this is avatar"  data-toggle="modal" data-target="#exampleModal" >
    </div>
        @include('components.profile_component')
        @include('components.update_profile_component')
    @endif
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
