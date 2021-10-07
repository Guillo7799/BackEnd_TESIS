<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Application;
use App\Models\User;
use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Application as ApplicationResource;
use App\Http\Resources\ApplicationCollection;
use App\Http\Resources\Publication as PublicationResource;
use App\Http\Resources\PublicationCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicationController extends Controller
{
    private static $rules=[
        'business_name'=>'required',
        'career'=>'required',
        'description' => 'required|string|unique:publications|max:300',
        'hours' => 'required',
        'date'=> 'required',
        'city'=>'required',
        'contact_email'=>'required',
        'category_id' => 'required|exists:categories,id',
    ];

    private static $messages=[
        'business_name'=>'Ingrese el nombre de su organización',
        'career.required' => 'Es necesario que ingrese la carrera de la que solicita un practicante',
        'description.required' => 'Falta la descripión, donde se incluye el tipo de actividades que realizaría el pasante',
        'hours.required' => 'Falta especificar cuantas horas deprácticas oferta',
        'date.required' => 'Falta el ingreso de fecha en la que realiza la publicación',
        'city'=>'Falta que ingrese la ciudad',
        'contact_email'=>'Ingrese un correo de contacto',
        'category_id.required' => 'Falta la categoría de la carrera',
    ];
    public function index()
    {
        //$this->authorize('viewAny', Publication::class);
        return new PublicationCollection(Publication::paginate(5));
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
    public function publicationFilter(Category $category)
    {
        $this->authorize('filter', Publication::class);
        $publication=Publication::where('category_id',$category['id'])->get();
        return response()->json(new PublicationCollection($publication),200);
    }
    public function applicationByPublication(Publication $publication)
    {
        $this->authorize('viewapplication', Publication::class);
        $application=Application::where('publication_id',$publication['id'])->get();
        return response()->json(new ApplicationCollection($application),200);
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
    public function deletePublicationUser(User $user, Publication $publication){
        $this->authorize('deletePublicationUser', Publication::class);
        $users = Publication::where('user_id','===','user.id')->get();
        $publication->delete();
        return response()->json(null, 204);
    }  
}