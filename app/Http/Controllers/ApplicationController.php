<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Application as ApplicationResource;
use App\Http\Resources\ApplicationCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    private static $rules=[
        'name'=>'required',
        'last_name' => 'required',
        'message' => 'required|string|unique:applications|max:1000',
        'publication_id' => 'required|exists:publications,id',
    ];

    private static $messages=[
        'name.required' => 'Es necesario que ingrese su nombre',
        'last_name.required' => 'Es necesario que ingrese su apellido',
        'message.required' => 'Es necesario que ingrese un mensaje de postulación',
        'publication_id.required' => 'Falta la categoría de la carrera',
    ];
    public function index()
    {
        //$this->authorize('viewAny', Publication::class);
        return new ApplicationCollection(Application::paginate(10));
    }    
    public function show(Application $application)
    {
        $this->authorize('view', $application);
        return response()->json(new ApplicationResource($application), 200);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Application::class);

        $request->validate(self::$rules, self::$messages);
        $application = Application::create($request->all());
        return response()->json($application, 201);
    }
    public function applicationsToUser( )
    {
        $user = Auth::user();
        return new ApplicationCollection($user->application);
    }
    public function update(Request $request, Publication $publication)
    {
        $this->authorize('update',$publication);

        $request->validate([
            'status' => 'required|string|unique:applications,message,'.$message->id.'|max:1000',
        ], self::$messages);
        $publication->update($request->all());
        return response()->json($publication, 200);
    }
    public function delete(Application $application)
    {
        $application->delete();
        return response()->json(null, 204);
    }   
}