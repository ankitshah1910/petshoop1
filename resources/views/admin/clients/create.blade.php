@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{isset($client)?'Edit User ' . $client->name:'Create Client'}}</div>
                    <div class="card-body">
                        <form method="POST" action="{{isset($client)?route('admin.clients.update', $client):route('admin.clients.store')}}">
                            @csrf
                            @if (isset($client))
                                {{method_field('PUT')}}
                            @else
                                {{method_field('POST')}}
                            @endif
                            @if (Auth::user()->hasRole('admin'))
                                <div class="form-group">
                                    <label for="user_id">Select User of:</label>
                                    <select name="user_id" class="form-control" id="user_id" required>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} - {{$user->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{isset($client)?$client->name:old('name')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{isset($client)?$client->email:old('email')}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" value="{{isset($client)?$client->phone:old('phone')}}" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>{{isset($client)?'Edit':'Create'}}
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

