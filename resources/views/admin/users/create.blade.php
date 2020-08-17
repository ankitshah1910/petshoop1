@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{isset($user)?'Edit User ' . $user->name:'Create User'}}</div>
                    <div class="card-body">
                        <form method="POST" action="{{isset($user)?route('admin.users.update', $user):route('admin.users.store')}}">
                            @csrf
                            @if (isset($user))
                                {{method_field('PUT')}}
                            @else
                                {{method_field('POST')}}
                            @endif

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{isset($user)?$user->name:old('name')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{isset($user)?$user->email:old('email')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="shop_name">Shop Name</label>
                                <input type="text" name="shop_name" value="{{isset($user)?$user->shop_name:old('shop_name')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="ph_number">Phone Number</label>
                                <input type="text" name="ph_number" value="{{isset($user)?$user->ph_number:old('ph_number')}}" class="form-control" required>
                            </div>

                            @if (!isset($user))

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" name="password" value="{{isset($user)?$user->password:old('password')}}" class="form-control" required>
                            </div>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>{{isset($user)?'Edit':'Create'}}
                            </button>
                            @if(count($errors))
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

