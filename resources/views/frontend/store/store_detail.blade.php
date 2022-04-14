@extends('layouts.main')
@section('title', 'store')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{Storage::disk('public')->url($store->images)}}" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{{$store->name}}</h5>
            @if ($user && $user->store->id == $store->id)
            <div class="row">
                <div class="col-md-6">
                  <a href="{{route('store.edit', $store->id)}}" class="btn btn-primary">Edit</a>
                </div>
                <div class="col-md-2">
                  <form action="{{route('store.destroy', $store->id)}}" method="post" class="form-inline">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
                </div>

            </div>
            @else
                <a href="" class="btn btn-primary" style="width: 100%" >Follow</a>
            @endif

            </div>
          </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <p>Products: {{count($store->products)}} </p>
            </div>
            <div class="col-md-6">
                <p>Followers: {{$store->followers}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>Following: {{$store->follow}} </p>
            </div>
            <div class="col-md-6">
                <p>Rates: {{$store->rates}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Description: {{$store->description}}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if ($user && $user->store->id == $store->id)
        <a href="{{route('product.create')}}" class="btn btn-success">add product</a>
        @endif
        <a href="/home" class="btn btn-primary">home</a>
    </div>
</div>
<div class="row">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>name</th>
                <th>price</th>
                <th>sales</th>
                <th>image</th>
                <th>option</th>
            </tr>
        </thead>
        <tbody>
            @if ($store->products)
                @foreach ($store->products as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>@if ($item->sales == 0)
                        <span>0</span>
                        @else
                        {{$item->sales}}
                        @endif
                    </td>
                    <td><img src="{{Storage::disk('public')->url($item->images)}}" alt=""
                            style="width: 100px; height:80px"></td>
                    @if ($user && $user->store->id == $store->id)
                    <td>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{route("product.edit",$item->id)}}" class="btn btn-warning">edit</a>
                            </div>
                            <div class="col-md-2">
                                <form action="{{route('product.destroy', $item->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
