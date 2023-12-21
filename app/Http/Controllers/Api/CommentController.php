<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
        ]);



        $request['user_id'] = auth()->user()->id;
        $comment = Comment::create($request->all());

        // return response()->json([]);

        return new CommentResource($comment->loadMissing(['comentator']));



    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'comments_content' => 'required'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update(request()->all());

        return new CommentResource($comment->loadMissing(['comentator']));
    }


    public function destroy($id)
    {


        $comment = Comment::findOrFail($id);
        $comment->delete();
    }


}
