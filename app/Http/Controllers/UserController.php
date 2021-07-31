<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Publication;
use App\Models\Business;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = JWTAuth::user();
        return response()->json(compact('token','user'))
            ->withCookie(
              'token',
              $token,
              config('jwt.ttl'), // ttl => time to live
              '/', // path
              null, // domain
              config('app.env') !== 'local', // secure
              true, // httpOnly
              false,
              config('app.env') !== 'local' ? 'None' : 'Lax' // SameSite
            );
    }
    public function businessregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'province' => 'required|string|max:300',
            'city' => 'required|string|max:300',
            'location'=>'required|string',
            'description' => 'required|string|max:1000',
            'cellphone' => 'required',
            'image' => 'required|image', //verificar como hacerla opcional
            'role'=>'required',
            //Validaciones para Empresa
            'ruc'=>'string|min:13|max:13',
            'business_name'=>'nullable|string|max:300',
            'business_type'=>'nullable|string',
            'business_age'=>'nullable|string'
        ]);        
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }                
        $business=Business::create([
            'ruc'=>$request->get('ruc'),
            'business_name'=>$request->get('business_name'),
            'business_type'=>$request->get('business_type'),
            'business_age'=>$request->get('business_age'),
        ]);               
        $path = $request->image->store('public/images');
        $business -> user()->create([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'province' => $request->get('province'),
            'city' => $request->get('city'),
            'location' => $request->get('location'),
            'type' => $request->get('type'),
            'description' => $request->get('description'),
            'career' => $request->get('career'),
            'cellphone' => $request->get('cellphone'),
            'image' => $path,
            'role'=>$request->get('role'),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201)
            ->withCookie(
                'token',
                $token,
                config('jwt.ttl'), // ttl => time to live
                '/', // path
                null, // domain
                config('app.env') !== 'local', // secure
                true, // httpOnly
                false,
                config('app.env') !== 'local' ? 'None' : 'Lax' // SameSite
            );      
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'province' => 'required|string|max:300',
            'city' => 'required|string|max:300',
            'location' => 'required|string|max:500',            
            'description' => 'required|string|max:1000',            
            'cellphone' => 'required',
            'image' => 'nullable|image', //verificar como hacerla opcional
            'role'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }        
        $path = $request->image->store('public/images');
        $user = User::create([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'province' => $request->get('province'),
            'city' => $request->get('city'),
            'location' => $request->get('location'),
            'description' => $request->get('description'),
            'cellphone' => $request->get('cellphone'),
            'image' => $path,
            'role'=>$request->get('role'),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201)
            ->withCookie(
                'token',
                $token,
                config('jwt.ttl'), // ttl => time to live
                '/', // path
                null, // domain
                config('app.env') !== 'local', // secure
                true, // httpOnly
                false,
                config('app.env') !== 'local' ? 'None' : 'Lax' // SameSite
            );
    }
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(new UserResource($user),200);
    }
    public function index(Publication $publication, User $user)
    {
        $user=$publication->users;
        return response()->json(UserResource::Collection($publication),200);
    }
    public function show(Publication $publication, User $user)
    {
        $user=$publication->users()->where('id', $user->id)->firstOrFail();
        return response()->json($user, 200); 
    }
}