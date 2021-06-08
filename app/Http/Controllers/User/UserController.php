<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;


class UserController extends ApiController
{
    
    public function store(UserStoreRequest $request)
    {
        $data=$request->only(['name','email','password']);
        $data['password']=Hash::make($request->password);
        $user=User::create($data);
        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $user->image()->create(['url'=>$image]);
        }
        
        return $this->showModelAsResponse($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //To be replaced with currently authenticated user
        
        return $this->showModelAsResponse($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->only(['name','email','password']));
        //doubtful regarding the update of files
        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $user->image()->updateOrCreate(['url'=>$image]);
        }
        return $this->showModelAsResponse($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        //Should Replace user instance with logged in user

        $user->delete();
        return $this->showModelAsResponse($user);
    }
}
