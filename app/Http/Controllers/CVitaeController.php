<?php

namespace App\Http\Controllers;

use App\Models\CVitae;
use App\Models\User;
use App\Http\Resources\CVitae as CVitaeResource;
use App\Http\Resources\CVitaeCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        'university.required' => 'Falta la universidad en la que estudias',
        'career.required'=>'Falta ingresar la carrera que sigues',
        'language.required'=>'Falta que ingrese otro idioma a parte del nativo',
        'level_language.required'=>'Falta que ingrese el nivel que tienes en el idioma',
        'habilities.required'=>'Falta que ingrese sus habilidades',
        'certificates.required'=>'Los certificados son requeridos',
        'highschool_degree.required'=>'Ingrese su título de segundo nivel',
        'work_experience.required'=>'Ingrese su experiencia laboral',
        'image.required' => 'Se necesita la imagen del curriculum',
    ];

    public function index()
    {
        return new CVitaeCollection(CVitae::paginate(5));
    }
    public function show(CVitae $cVitae)
    {
        $this->authorize('view', $cVitae);
        return response()->json(new CVitaeResource($cVitae), 200);
    }
    public function store(Request $request)
    {
        $this->authorize('create', CVitae::class);
    
        $request -> validate(self::$rules, self::$messages);
        $cVitae = CVitae::create($request->all());
        $path = $request->image->store('public/cvitaes');
        $cVitae->image = 'cvitaes/' . basename($path);
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
            'habilities' => 'required|string|unique:c_vitaes,habilities,'.$cVitae->id.'|max:1000',
            'certificates' => 'required|string|max:3000',
            'work_experience'=>'required|string|max:3000',
        ], self::$messages);
        $cVitae->update($request->all());
        return response()->json($cVitae, 200);
    }
    public function delete(CVitae $cVitae)
    {
        $cVitae->delete();
        return response()->json(null, 204);
    }
    public function showCVitaeUser(User $user){
        $this->authorize('viewCVitaeUser', CVitae::class);
        $users = CVitae::where('user_id','===','user.id')->get();
        return response()->json(new CVitaeResource($users), 200);
    }

    public function images(CVitae $cVitae){
        return response()->download(public_path(Storage::url($cVitae->image)), $cVitae->habilities);
    }

}