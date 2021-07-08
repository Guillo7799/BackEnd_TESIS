<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private static $messages = [
        'designation.required' => 'Falta el nombre de la nueva categoría',
    ];
    
    private static $rules=[
        'designation' => 'required|string|unique:categories|max:300',
    ];

    public function index()
    {
        return new CategoryCollection(Category::paginate(7));
    }
    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category), 200);
    }
    public function store(Request $request)
    {
        $request ->validate(self::$rules, self::$messages);
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return response()->json($category, 200);
    }
    public function delete(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
