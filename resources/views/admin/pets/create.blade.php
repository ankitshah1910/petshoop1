@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{isset($pets)?'Edit Pet ' . $pets->name:'Add Pet'}}</div>
                    <div class="card-body">
                        <form method="POST" action="{{isset($pets)?route('admin.pets.update', $pets):route('admin.pets.store')}}" enctype="multipart/form-data">
                            @csrf

                            @if (isset($pets))
                                {{method_field('PUT')}}
                            @else
                                {{method_field('POST')}}
                            @endif
                            <div class="form-group">
                                <label for="client_id">Select Pet of:</label>
                                <select name="client_id" class="form-control" id="client_id" required>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}} - {{$client->email}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{isset($pets)?$pets->name:''}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" name="age" min="0" max="50" value="{{isset($pets)?$pets->age:''}}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <div class="row justify-content-around">
                                    <label for="sex">Sex</label>
                                    <input type="radio" id="male" name="sex" value="1" {{isset($pets)?$pets->sex=="1"?'selected':'':''}} required>
                                    <label for="male">Male</label><br>
                                    <input type="radio" id="female" name="sex" value="2" {{isset($pets)?$pets->sex=="2"?'selected':'':''}} required>
                                    <label for="female">Female</label><br>
                                    <input type="radio" id="other" name="sex" value="3" {{isset($pets)?$pets->sex=="3"?'selected':'':''}} required>
                                    <label for="other">Other</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="breed">Breed</label>
                                <input type="text" name="breed" value="{{isset($pets)?$pets->breed:''}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Choose Image</label>
                                <input id="image" type="file" name="image" onchange="readURL(this);" ><br>
                                <img id="previewimage" src="{{isset($pets)?asset($pets->image):asset('uploads/images/defaultpet.png')}}" alt="image preview" class="img-thumbnail" height="130" width="130"/><br>
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea type="text" name="note" class="form-control" required>{{isset($pets)?$pets->note:''}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>{{isset($pets)?'Edit':'Create'}}
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
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewimage')
                    .attr('src', e.target.result)
                    .width(130)
                    .height(130);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

