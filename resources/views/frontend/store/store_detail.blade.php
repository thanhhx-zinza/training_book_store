@extends('layouts.main')
@section('title', 'cua hang')
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
                  <a href="{{route('edit_store')}}" class="btn btn-primary">Chinh sua</a>
                </div>
                <div class="col-md-2">
                  <form action="{{route('delete_store')}}" method="post" class="form-inline">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger" type="submit">Xoa</button>
                  </form>
                </div>

            </div>
            @else
                <a href="" class="btn btn-primary" style="width: 100%" >theo doi</a>
            @endif

            </div>
          </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <p>San pham: {{count($store->product)}} </p>
            </div>
            <div class="col-md-6">
                <p>Nguoi theo doi: {{$store->followers}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>Dang theo doi: {{$store->follow}} </p>
            </div>
            <div class="col-md-6">
                <p>Danh gia: {{$store->rates}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Mo ta: {{$store->description}}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if ($user && $user->store->id == $store->id)
        <a href="{{route('create_product')}}" class="btn btn-success">Them moi san pham</a>
        @endif
        <a href="/" class="btn btn-primary">Trang chu</a>
    </div>
</div>
<div class="row">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ten san pham</th>
                <th>Gia</th>
                <th>Da ban</th>
                <th>Hinh anh</th>
                <th>Tuy chon</th>
            </tr>
        </thead>
        <tbody>
            @if ($store->product)
                @foreach ($store->product as $item)
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
                                <a href="{{route("edit_product",$item->slug)}}" class="btn btn-warning">Sua</a>
                            </div>
                            <div class="col-md-2">
                                <form action="{{route('delete_product', $item->slug)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">Xoa</button>
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
