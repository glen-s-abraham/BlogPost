<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;


class UserController extends ApiController
{

    private $userRepositoryInterface;
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface=$userRepositoryInterface;
    }


    //Registration
    public function store(UserStoreRequest $request)
    {
        $data=$request->only(['name','email','password']);
        $data['password']=Hash::make($request->password);
        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $data['image']=$image;
        }

        $user=$this->userRepositoryInterface->addNewUser($data);
        
        return $this->successResponse(['user'=>$user],201);
          
    }

    //Login Controller
    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid login details',401); 
        }
              
        $token=$this->userRepositoryInterface->createUserToken($request->email);

        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => "User logged in successfully",
        ],200);
    }

    //Profile
    public function show()
    {
        $user=auth()->user()->formatProfile();
        return $this->successResponse(['user'=>$user],200);
        
    }

    //Update profile   
    public function update(UserUpdateRequest $request)
    {
        $data=$request->only(['name','email','password']);

        if($request->hasFile('image'))
        {
            $image=$request->file('image')->store('public/profiles');
            $data['image']=$image;
        }
        
        $user=$this->userRepositoryInterface->updateExistingUser(auth()->user()->id,$data);

        return $this->successResponse(['user'=>$user],200);
    }

    //delete profile
    public function destroy()
    {
             
        $user=$this->userRepositoryInterface->deleteExistingUser(auth()->user()->id);
        return $this->successResponse(['message'=>'Removed account'],200);
    }

    //Logout
    public function logout(Request $request)
    {
        
        $this->userRepositoryInterface->deleteUserToken(auth()->user()->id);
        return $this->successResponse(['message' => 'User successfully signed out'],200);
    }
}
