<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;


class UserController extends ApiController
{
    
    public function store(UserStoreRequest $request)
    {
        $data=$request->all();
        $data['password']=bcrypt($request->password);
        $user=User::create($data);
        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $user->image()->create(['url'=>$image]);
        }
      
        

        return $this->showOne($user,201);
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
        
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        //Should Replace user instance with logged in user

        if($request->has('name')){
            $user->name=$request->name;
        }

        if($request->has('email') && $user->email != $request->email){
            $user->email=$request->email;

        }

        if($request->has('password')){
            $password=bcrypt($request->password);
            $user->password=$password;   
            
        }

        //doubtful regarding the update of files
        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $user->image()->updateOrCreate(['url'=>$image]);
        }

        if(!$user->isDirty())
        {

            return $this->errorResponse("You need to specify a different value to update",422);
        }

        $user->save();

        return $this->showOne($user);
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
        return $this->showOne($user);
    }
}
