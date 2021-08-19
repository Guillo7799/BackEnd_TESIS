<?php

namespace App\Http\Controllers;

use App\Models\CVitae;
use App\Models\User;
use App\Http\Resources\CVitae as CVitaeResource;
use App\Http\Resources\CVitaeCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CVitaeController extends Controller
{
    private static $rules=[
        'university' => 'required|string|max:2000',
        'career'=>'required|string|max:300',
        'language'=>'required|string|max:50',
        'level_language'=>'required|string|max:50',
        'habilities'=>'required|string|max:1000',
        'certificates'=>'required|string|max:3000',
        'highschool_degree'=>'required|string|max:500',
        'work_experience'=>'required|string|max:3000',
        'image' => 'required|image',
    ];

    private static $messages=[
        'university' => 'Falta la universidad en la que estudias',
        'career'=>'Falta ingresar la carrera que sigues',
        'language'=>'Falta que ingrese otro idioma a parte del nativo',
        'level_language'=>'Falta que ingrese el nivel que tienes en el idioma',
        'habilities'=>'required|string|max:1000',
        'certificates'=>'required|string|max:3000',
        'highschool_degree'=>'required|string|max:500',
        'work_experience'=>'required|string|max:3000',
        'image' => 'required|image',
    ];

    public function index()
    {
        return new CVitaeCollection(CVitae::paginate(5));
    }
    public function show(CVitae $cVitae)
    {
        return response()->json(new CVitaeResource($cVitae), 200);
    }
    public function store(Request $request)
    {
        $this->authorize('create', CVitae::class);
    
        $request -> validate(self::$rules, self::$messages);
        $cVitae = CVitae::create($request->all());
        $path = $request->image->store('cvitaes');
        $cVitae->image = $path;
        $cVitae->save();
        return response()->json($cVitae, 201);
    }
    public function image(CVitae $cVitae)
    {
    return response()->download(public_path(Storage::url($cVitae->image)),
    $cVitae->title);
    }
    public function update(Request $request, CVitae $cVitae)
    {
        $this->authorize('update',$cVitae);

        $request->validate([
            'habilities' => 'required|string|unique:curriculums,habilities,'.$curriculum->id.'|max:1000',
            'certificates' => 'required|string|max:3000',
            'work_experience'=>'required|string|max:3000',
            'image' => 'required|image',
        ], self::$messages);
        $cVitae->update($request->all());
        return response()->json($cVitae, 200);
    }
    public function delete(CVitae $cVitae)
    {
        $cVitae->delete();
        return response()->json(null, 204);
    }
    public function showCVitaeUser(){
        $this->authorize('viewCVitaeUser', CVitae::class);
        $users = CVitae::where('user_id','!=',NULL)->get();
        return response()->json(new CVitaeResource($users), 200);
    }
}