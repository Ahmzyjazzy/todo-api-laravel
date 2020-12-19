<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource; 
use App\Models\User;  
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class UserController extends Controller
{
    protected function respondWithToken($user, $token)
    {
      return response()->json([
        'data'          =>  $user,
        'access_token'  =>  $token,
        'token_type'    =>  'bearer',     
        'expires_in'    =>  auth('api')->factory()->getTTL() * 60
      ]);
    }

    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|min:3|unique:users',
            'firstname' => 'required|string|max:255|min:3',
            'lastname' => 'required|string|max:255|min:3',
            'phone' => 'required|regex:/^[2-9]{3}\d{10}$/|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response([
                'errors'=>$validator->errors()->all(),
                'status' => false,
                'data' => null
            ], 422);
        } 

        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $request['username'] = $request->username;
        $request['role_id'] = 1;
        $user = User::create($request->toArray()); 
        
        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($user,$token);
    }

    public function login (Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $credentials = $request->only(['email', 'password']);
        

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Incorrect Credentials'
            ], 401);
        }

        $token = JWTAuth::fromUser(auth()->user());

        return $this->respondWithToken(auth()->user(),$token);
    }
  
    //get user
    public function getAuthUser(Request $request)
    {
        return new UserResource(auth()->user());
    }
    
    //logout
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function unAthorised(Request $request)
    {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
