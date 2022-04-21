@extends('layouts.main')
@section('title', 'store')
@section('content')
<div class="row">
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Store</th>
                    <th>action</th>
                </tr>
                <tbody>
                    @foreach ($stores as $store)
                        <tr>
                            <td>{{$store->id}}</td>
                            <td>{{$store->name}}</td>
                            <td>
                                <a href="{{route('store.show', $store->id)}}">View</a>  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </thead>
        </table>
    </div>
</div>
@endsection
