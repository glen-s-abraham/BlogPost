<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends ApiController
{
    //Registration
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

    //Login Controller
    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid login details',401); 
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => "User logged in successfully",
        ],200);
    }

    //Profile
    public function show()
    {
        $user=auth()->user();
        return $this->showModelAsResponse($user);
    }

    //Update profile   
    public function update(UserUpdateRequest $request)
    {
        $user=auth()->user();
        $user->update($request->only(['name','email','password']));
        //doubtful regarding the update of files
        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $user->image()->updateOrCreate(['url'=>$image]);
        }
      
        return $this->showModelAsResponse($user);
    }

    //delete profile
    public function destroy()
    {

        //Should Replace user instance with logged in user
        $user=auth()->user();
        $user->delete();
        return $this->showModelAsResponse($user);
    }

    //Logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
