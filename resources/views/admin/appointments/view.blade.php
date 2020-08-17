@extends('layouts.admin')
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
@section('content')
    <!-- Content Header (Page header) -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{isset($appointments)?'Edit Appointment ' . $appointments->name:'Add Appointment'}}</div>
                    <div class="card-body">
                        <form method="POST" action="{{isset($appointments)?route('admin.appointments.update', $appointments):route('admin.appointments.store')}}">
                            @csrf

                            @if (isset($appointments))
                                {{method_field('PUT')}}
                            @else
                                {{method_field('POST')}}
                            @endif
                            <div class="form-group">
                                <label for="pet_id">Select Pet for Appointment:</label>
                                <select name="pet_id" class="form-control" id="client_id" required disabled>
                                    @foreach($pets as $pet)
                                        <option value="{{$pet->id}}">{{$pet->name}} - {{$pet->breed}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div class="form-group">
                                <label>Appointment Date:</label>
                                <input type="text" name="appointment_time" class="form-control" value="{{isset($appointments)?$appointments->appointment_time:''}}" disabled required/>
                            </div>

                            <div class="form-group">
                                <label for="description">Special Note/Description</label>
                                <textarea type="text" name="description" class="form-control" required disabled>{{isset($appointments)?$appointments->description:''}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>{{isset($appointments)?'Edit':'Create'}}
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

@endsection<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(function () {
        //Date range picker
        $('#reservationdate').datetimepicker({
            timePicker: false,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            },
            format: 'L'
        });
    })
</script>
