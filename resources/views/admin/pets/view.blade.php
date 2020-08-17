@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{isset($client)?'View User - ' . $client->name:'Create Client'}}</div>
                    <div class="card-body">
                        <form method="POST" action="{{isset($client)?route('admin.clients.update', $client):route('admin.clients.store')}}">
                            @csrf
                            {{method_field('POST')}}
                            @if (Auth::user()->hasRole('admin'))
                                <div class="form-group">
                                    <label for="user_id">Select User of:</label>
                                    <select name="user_id" class="form-control" id="user_id" disabled>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}} - {{$user->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{isset($client)?$client->name:''}}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{isset($client)?$client->email:''}}" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" name="phone" value="{{isset($client)?$client->phone:''}}" class="form-control" disabled>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

