@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <h3>Pets</h3>
                        <a href="{{route('admin.pets.create')}}"><button class="btn btn-primary">Add new</button></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pet of Client</th>

                            @if (Auth::user()->hasRole('admin'))
                                <th scope="col">Pet of Shop</th>
                            @endif


                            <th scope="col">Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Sex</th>
                            <th scope="col">Breed</th>
                            <th scope="col">Image</th>
                            <th scope="col">Note</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pets as $pet)
                            <tr>
                                <th scope="row">{{$pet->id}}</th>
                                <td>{{$pet->client->name}}</td>

                                @if (Auth::user()->hasRole('admin'))
                                    <td>{{$pet->client->user->name}}</td>
                                @endif

                                <td>{{$pet->name}}</td>
                                <td>{{$pet->age}}</td>
                                <td>{{$pet->sex}}</td>
                                <td>{{$pet->breed}}</td>
                                <td><img src="{{asset($pet->image)}}" alt="{{$pet->image}}" height="100" width="100" class="img-thumbnail"></td>
                                <td>{{$pet->note}}</td>
                                <td class="content-center">
                                    <a href="{{route('admin.pets.edit',$pet->id)}}"><i class="fas fa-edit float-left ml-3"></i></a>
                                    <a href="{{route('admin.pets.show',$pet->id)}}"><i class="fas fa-info float-left ml-3"></i></a>
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
                                                    <form action="{{route('admin.pets.destroy',$pet)}}" method="POST" class="float-left">
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
