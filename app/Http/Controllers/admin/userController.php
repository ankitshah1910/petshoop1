<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function GuzzleHttp\Promise\all;

class userController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::whereHas('roles', function($q){$q->where('name', 'user');})->get();
        return view('admin.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        return view('admin.users.create')->with([
            'roles'=>$roles
        ]);
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
            'ph_number' => 'required',
            'shop_name' => 'required',
            'password' => 'required',
        ]);

        $user= User::create([
            'name' =>  $request->get('name'),
            'email' =>  $request->get('email'),
            'ph_number' =>  $request->get('ph_number'),
            'shop_name' =>  $request->get('shop_name'),
            'password' => Hash::make( $request->get('password')),
        ]);
        $role=Role::select('id')->where('name','user')->first();
        $user->roles()->attach($role);
//        sendEmailpassword($user);
        return redirect()->route('admin.users.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        }

        $roles=Role::all();
        return view('admin.users.view')->with([
            'user'=>$user,
            'roles'=>$roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        }
        $roles=Role::all();
        return view('admin.users.create')->with([
            'user'=>$user,
            'roles'=>$roles
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
        $this->validate(request(), [
            'name' =>  'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ph_number' => 'required',
            'shop_name' => 'required',
        ]);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->shop_name = $request->get('shop_name');
        $user->ph_number = $request->get('ph_number');
        if($user->save()){
            $request->session()->flash('success',$user->name . ' User has been Updated');
        }else{
            $request->session()->flash('error','User has not been Updated');
        }
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Gate::denies('delete-users')){
            return redirect(route('admin.users.index'));
        }
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.users.index');
    }

    public function sendEmailpassword(Request $request, $user)
    {

        Mail::send('emails.welcome', ['user' => $user], function ($m) use ($user) {
            $m->from(Auth::user()->email, 'Pet Shop');
            $m->to($user->email, $user->name)->subject('Your New Account Registration!');
        });
    }



}
