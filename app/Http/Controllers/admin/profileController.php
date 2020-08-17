<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $user=Auth::user();

        return view('admin.profile.index')->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user=Auth::user();
        return view('admin.profile.edit')->with([
            'user'=>$user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user=Auth::user();
        $this->validate(request(), [
            'name' =>  'required',
            'email' => 'required',
            'ph_number' => 'required',
        ]);
        $shop_name=$request->has('shop_name')?$request->get('shop_name'):'';

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->ph_number = $request->get('ph_number');
        $user->shop_name = $shop_name;
        if($user->save()){
            $request->session()->flash('success',$user->name . ' has been Updated');
        }else{
            $request->session()->flash('error','Profile has not been Updated');
        }
        return redirect()->route('admin.profile.index');
    }

    public function editpass(User $user)
    {
        $user=Auth::user();
        return view('admin.profile.changepass')->with([
            'user'=>$user,
        ]);
    }
    public function updatepass(Request $request, User $user)
    {
        $user=Auth::user();
        $this->validate(request(), [
            'name' =>  'required',
            'email' => 'required',
            'ph_number' => 'required',
        ]);
        $shop_name=$request->has('shop_name')?$request->get('shop_name'):'';

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->ph_number = $request->get('ph_number');
        $user->shop_name = $shop_name;
        if($user->save()){
            $request->session()->flash('success',$user->name . ' has been Updated');
        }else{
            $request->session()->flash('error','Profile has not been Updated');
        }
        return redirect()->route('admin.profile.index');
    }
}
