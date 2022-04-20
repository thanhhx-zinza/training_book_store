@extends('layouts.main')
@section('title', 'store')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{Storage::disk('public')->url($store->images)}}" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{{$store->name}}</h5>

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
            </div>
          </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <p>Products: {{count($store->products)}} </p>
            </div>
            <div class="col-md-6">
                <p>followers: {{$store->followers}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>following: {{$store->follow}} </p>
            </div>
            <div class="col-md-6">
                <p>rates: {{$store->rates}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>description: {{$store->description}}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{route('product.create',['id' => $store->id])}}" class="btn btn-success">create product</a>
        <a href="{{route('home')}}" class="btn btn-primary">home</a>
    </div>
</div>
<div class="row">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>name</th>
                <th>price</th>
                <th>sales</th>
                <th>images</th>
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
                    <td>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="{{route('product.edit', ['product' => $item->id, 'storeId' => $store->id])}}" class="btn btn-warning">edit</a>
                            </div>
                            <div class="col-md-2">
                                <form action="{{route('product.destroy', ['product' => $item->id, 'storeId' => $store->id])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <button class="btn btn-danger" type="submit" >delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
