<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index()
    {
        return Publication::all();
    }
    public function show(Publication $publication)
    {
        return $publication;
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
