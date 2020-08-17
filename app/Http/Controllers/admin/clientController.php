<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Http\Controllers\Controller;
use App\pet;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class clientController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $clients=Client::all();
//        dd($clients[0]->user->name);

        return view('admin.clients.index')->with('clients',$clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::whereHas('roles', function($q){$q->where('name', 'user');})->get();
        return view('admin.clients.create')->with('users',$users);
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
            'name' =>  'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required',
        ]);

        $client= Client::create([
            'user_id'=>$request->get('user_id')==null?Auth::user()->id:$request->get('user_id'),
            'name' =>  $request->get('name'),
            'email' =>  $request->get('email'),
            'phone' =>  $request->get('phone'),
        ]);
        return redirect()->route('admin.clients.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        return view('admin.clients.view')->with([
            'client'=>$client,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(client $client)
    {
        $users = User::whereHas('roles', function($q){$q->where('name', 'user');})->get();
        return view('admin.clients.create')->with([
            'client'=>$client,
            'users'=>$users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate(request(), [
            'name' =>  'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required',
        ]);

        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        if($client->save()){
            $request->session()->flash('success',$client->name . ' Client has been Updated');
        }else{
            $request->session()->flash('error','client has not been Updated');
        }
        return redirect()->route('admin.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index');
    }



}
