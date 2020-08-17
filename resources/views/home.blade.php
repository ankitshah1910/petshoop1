@extends('layouts.admin')

@if (Auth::user()->hasRole('admin'))

@endif
@section('content')



@endsection
