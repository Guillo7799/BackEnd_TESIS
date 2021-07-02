<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Http\Resources\Publication as PublicationResource;
use App\Http\Resources\PublicationCollection;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index()
    {
        return new PublicationCollection(Publication::paginate(10));
    }
    public function show(Publication $publication)
    {
        return response()->json(new PublicationResource($publication), 200);
    }
    public function store(Request $request)
    {
        $publication = Publication::create($request->all());
        return response()->json($publication, 201);
    }
    public function update(Request $request, Publication $publication)
    {
        $publication->update($request->all());
        return response()->json($publication, 200);
    }
    public function delete(Publication $publication)
    {
        $publication->delete();
        return response()->json(null, 204);
    }
}
