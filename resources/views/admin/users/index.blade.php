@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <h3>Users</h3>
                            <a href="{{route('admin.users.create')}}"><button class="btn btn-primary">Add new</button></a>
                        </div>

                    </div>
                    <div class="card-body">
                            <table id="datatables" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Shop Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->shop_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->ph_number}}</td>
                                        <td>{{implode($user->roles()->get()->pluck('name')->toArray())}}</td>
                                        <td class="content-center">
                                            <a href="{{route('admin.users.edit',$user->id)}}"><i class="fas fa-edit float-left ml-3"></i></a>
                                            <a href="{{route('admin.users.show',$user->id)}}"><i class="fas fa-info float-left ml-3"></i></a>
                                            <i type="button" class="fas fa-trash ml-3" data-toggle="modal" data-target="#deletemodal"></i>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete? This process is irreversible!
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <form action="{{route('admin.users.destroy',$user)}}" method="POST" class="float-left">
                                                                @csrf
                                                                {{method_field('DELETE')}}
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>

@endsection

