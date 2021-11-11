<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Publication;
use App\Models\Application;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Publication as PublicationResource;
use App\Http\Resources\PublicationCollection;
use App\Models\CVitae;
use App\Http\Resources\CVitae as CVitaeResource;
use App\Http\Resources\CVitaeCollection;
use App\Http\Resources\Application as ApplicationResource;
use App\Http\Resources\ApplicationCollection;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    private static $messages=[
        'required'=>'El campo: atribute es obligatorio',
    ];
    private static $curriculumMessages=[
        'habilities.required'=>'Falta que ingrese sus habilidades',
        'certificates.required'=>'Los certificados son requeridos',
        'work_experience.required'=>'Ingrese su experiencia laboral',
    ];
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
            'image' => 'nullable|image', //verificar como hacerla opcional
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
        //$path = $request->image->store('public/images');
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
            //'image' => $path,
            'role'=>$request->get('role'),
        ]); 
        $user=$business->user;
        $token = JWTAuth::fromUser($business->user);
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
            'role'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
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
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

//            Cookie::queue(Cookie::forget('token'));
//            $cookie = Cookie::forget('token');
//            $cookie->withSameSite('None');
            return response()->json([
                "status" => "Realizado con éxito",
                "message" => "Cierre de sesión exitoso"
            ], 200)
                ->withCookie('token', null,
                    config('jwt.ttl'),
                    '/',
                    null,
                    config('app.env') !== 'local',
                    true,
                    false,
                    config('app.env') !== 'local' ? 'None' : 'Lax'
                );
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(["message" => "No se pudo cerrar la sesión."], 500);
        }
    }
    public function showUserPublications(User $user){
        $this->authorize('viewUserPublications', User::class);
        $publications = Publication::where('user_id', $user['id'])->get();
        return response()->json(new PublicationCollection($publications), 200);
    }
    public function showUserCurriculum(User $user)
    {
        $this->authorize('viewUserCurriculum', User::class);
        $curriculum = CVitae::where('user_id', $user['id'])->get();
        return response()->json(new CVitaeCollection($curriculum), 200);
    }
    public function updateUserCurriculum(Request $request, User $user)
    {
        $this->authorize('updateUserCurriculum',User::class);
        $curriculum = CVitae::where('user_id', $user['id'])->get();
        $request->validate([
            'habilities' => 'required|string|unique:curriculums,habilities,'.$curriculum->id.'|max:1000',
            'certificates' => 'required|string|max:3000',
            'work_experience'=>'required|string|max:3000',
        ], self::$curriculumMessages);
        $curriculum->update($request->all());
        return response()->json($curriculum, 200);
    }
    public function showUserApplication(User $user){
        $this->authorize('viewUserApplication', User::class);
        $application = Application::where('user_id', $user['id'])->get();
        return response()->json(new ApplicationCollection($application), 200);
    }
    public function showApplicationPublication()
    {
        $user=Auth::user();
        $publications= Publication::where('user_id', $user['id'])->get();
        $postulations=array();
        foreach($publications as $publication)
        {
            $postulations[]=Application::where('publication_id','like',$publication->id);
        }
        $postulations = array_map("unserialize", array_unique(array_map("serialize", $postulations)));
        return response()->json($postulations, 200);
    }
    public function UpdateShowApplicationPublication(Application $application)
    {
        $this->authorize('updateApplicationPublication', User::class);
        $user=Auth::user();
        $publications= Publication::where('user_id', $user['id'])->get();
        $details= Application::where('publication_id', ($publications[0]->id))->get();
        $details->validate([
            'status' => 'required',
        ], self::$messages);
        $application->update($details());
        //dd($request);
        return response()->json(new ApplicationCollection($details), 200);
    }
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return User::all();
    }
    public function show(User $user){
        $this->authorize('view', $user);
        return response()->json(UserResource::collection($user),200);
    }
    public function update(Request $request, User $user)
    {
        //$this->authorize('update',User::class);
        $request->validate([
            'location' => 'required|string',            
            'description' => 'required|string',            
            'cellphone' => 'required|string',

        ],self::$messages);
        $user->update($request->all());
        return response()->json($user, 200);
    }
    public function updateBusiness(Request $request, User $user)
    {
        $this->authorize('updateBusiness',$user);
        $request->validate([
            'location' => 'required|string',  
            'description' => 'required|string',
            'cellphone' => 'required|string',
        ],self::$messages);
        $user->update($request->all());
        return response()->json($user, 200);
    }
    public function delete(User $user)
    {
        $this->authorize('delete',$user);
        $user->delete();
        return response()->json(null, 204);
    }
}