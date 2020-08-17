@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <h3>{{$user->name}}</h3>
                            <a href="{{route('admin.profile.edit',$user)}}"><button class="btn btn-primary">Edit</button></a>

                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" disabled>
                            </div>
                            @if (Auth::user()->hasRole('user'))
                                <div class="form-group">
                                    <label for="shop_name">Shop Name</label>
                                    <input type="text" name="shop_name" value="{{ $user->shop_name }}" class="form-control" disabled>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="ph_number">Phone Number</label>
                                <input type="text" name="ph_number" value="{{ $user->ph_number }}" class="form-control" disabled>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

