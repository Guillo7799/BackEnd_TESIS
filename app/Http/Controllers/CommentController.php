<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    private static $rules=[
        'content' => 'required|string|unique:comments|max:2000',
    ];

    private static $messages=[
        'content.required' => 'Falta el contenido del mensaje',
    ];

    public function index()
    {
        return new CommentCollection(Comment::paginate(5));
    }
    public function show(Comment $comment)
    {
        return response()->json(new CommentResource($comment), 200);
    }
    public function store(Request $request)
    {
        $request -> validate(self::$rules, self::$messages);
        $comment = Comment::create($request->all());
        return response()->json($comment, 201);
    }
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return response()->json($comment, 200);
    }
    public function delete(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
