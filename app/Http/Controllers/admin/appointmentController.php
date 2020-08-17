<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Client;
use App\Http\Controllers\Controller;
use App\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class appointmentController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $appointments=Appointment::all();
        return view('admin.appointments.index')->with('appointments',$appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pets = Pet::all();
        return view('admin.appointments.create')->with('pets',$pets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'appointment_time' =>  'required',
            'pet_id' => 'required',
        ]);

        $clientis=Pet::where('id', $request->get('pet_id'))->first();
        $client_idis = $clientis->client_id;

        $useris=Client::where('id', $client_idis)->first();
        $user_idis = $useris->user_id;

        $appointments= Appointment::create([
            'client_id'=>$client_idis,
            'user_id'=>$user_idis,
            'pet_id'=>$request->get('pet_id'),
            'appointment_time' =>  $request->get('appointment_time'),
            'description' =>  $request->get('description'),
        ]);
        return redirect()->route('admin.appointments.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $pets = Pet::all();
        return view('admin.appointments.view')->with([
            'pets'=>$pets,
            'appointments'=>$appointment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $pets = Pet::all();
        return view('admin.appointments.create')->with([
            'pets'=>$pets,
            'appointments'=>$appointment
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->validate(request(), [
            'appointment_time' =>  'required',
            'pet_id' => 'required',
        ]);

        $clientis=Pet::where('id', $request->get('pet_id'))->first();
        $client_idis = $clientis->client_id;

        $useris=Client::where('id', $client_idis)->first();
        $user_idis = $useris->user_id;


        $appointment->client_id = $client_idis;
        $appointment->user_id = $user_idis;
        $appointment->pet_id = $request->get('pet_id');
        $appointment->appointment_time = $request->get('appointment_time');
        $appointment->description = $request->get('description');

        if($appointment->save()){
            $request->session()->flash('success','Appointment has been Updated');
        }else{
            $request->session()->flash('error','Aappointment has not been Updated');
        }
        return redirect()->route('admin.appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index');
    }


}
