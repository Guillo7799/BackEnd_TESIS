<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Http\Resources\Publication as PublicationResource;
use App\Http\Resources\PublicationCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicationController extends Controller
{
    private static $rules=[
        'career'=>'required',
        'description' => 'required|string|unique:publications|max:300',
        'hours' => 'required',
        'date'=> 'required',
        'category_id' => 'required|exists:categories,id',
    ];

    private static $messages=[
        'career.required' => 'Es necesario que ingrese la carrera de la que solicita un practicante',
        'description.required' => 'Falta la descripión, donde se incluye el tipo de actividades que realizaría el pasante',
        'hours.required' => 'Falta especificar cuantas horas deprácticas oferta',
        'date.required' => 'Falta el ingreso de fecha en la que realiza la publicación',
        'category_id.required' => 'Falta la categoría de la carrera',
    ];
    public function index()
    {
        //$this->authorize('viewAny', Publication::class);
        return new PublicationCollection(Publication::paginate(10));
    }
    public function show(Publication $publication)
    {
        $this->authorize('view', $publication);
        return response()->json(new PublicationResource($publication), 200);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Publication::class);

        $request->validate(self::$rules, self::$messages);
        $publication = Publication::create($request->all());
        return response()->json($publication, 201);
    }
    public function update(Request $request, Publication $publication)
    {
        $this->authorize('update',$publication);

        $request->validate([
            'description' => 'required|string|unique:publications,description,'.$publication->id.'|max:300',
            'hours' => 'required',
        ], self::$messages);
        $publication->update($request->all());
        return response()->json($publication, 200);
    }
    public function delete(Publication $publication)
    {
        $publication->delete();
        return response()->json(null, 204);
    }
}