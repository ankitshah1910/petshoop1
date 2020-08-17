<?php

namespace App\Http\Controllers\admin;

use App\Client;
use App\Http\Controllers\Controller;
use App\Pet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class petController extends Controller
{

    public function _construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $pets=Pet::all();
//        dd($clients[0]->user->name);
        return view('admin.pets.index')->with('pets',$pets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        return view('admin.pets.create')->with('clients',$clients);
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
            'age' => 'required',
            'sex' => 'required',
            'breed' => 'required',
            'note' => 'required',
        ]);


        $useris=Client::where('id', $request->get('client_id'))->first();
        $user_idis = $useris->user_id;

        $filePath='/uploads/images/defaultpet.png';
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $image = $request->file('image');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('name')).'_'.time();
                // Define folder path
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

                $name1 = !is_null($name) ? $name : Str::random(25);

                $file1 = $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');

            }
        }
        $pets= Pet::create([
            'client_id'=>$request->get('client_id')==null?Auth::user()->id:$request->get('client_id'),
            'user_id'=>$user_idis,
            'name' =>  $request->get('name'),
            'age' =>  $request->get('age'),
            'sex' =>  $request->get('sex'),
            'breed' =>  $request->get('breed'),
            'image' =>  $filePath,
            'note' =>  $request->get('note'),
        ]);
        return redirect()->route('admin.pets.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        return view('admin.pets.view')->with([
            'pets'=>$pet,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        $client = Client::all();
        return view('admin.pets.create')->with([
            'clients'=>$client,
            'pets'=>$pet
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        $this->validate(request(), [
            'name' =>  'required',
            'age' => 'required',
            'sex' => 'required',
            'breed' => 'required',
            'note' => 'required',
        ]);

        $useris=Client::where('id', $request->get('client_id'))->first();
        $user_idis = $useris->user_id;

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $toDeleteImage = public_path("{$pet->image}"); // get previous image from folder
                if (File::exists($toDeleteImage && $pet->image!='/uploads/images/defaultpet.png')) { // unlink or remove previous image from folder
                    unlink($toDeleteImage);
                }

                $image = $request->file('image');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('name')).'_'.time();
                // Define folder path
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

                $name1 = !is_null($name) ? $name : Str::random(25);

                $file1 = $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');

                $pet->image = $filePath;
            }
        }

        $pet->client_id = $request->get('client_id')==null?Auth::user()->id:$request->get('client_id');
        $pet->user_id = $user_idis;
        $pet->name = $request->get('name');
        $pet->age = $request->get('age');
        $pet->sex = $request->get('sex');
        $pet->breed = $request->get('breed');

        $pet->note = $request->get('note');

        if($pet->save()){
            $request->session()->flash('success',$pet->name . '  has been Updated');
        }else{
            $request->session()->flash('error','Pet has not been Updated');
        }
        return redirect()->route('admin.pets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('admin.pets.index');
    }


}
