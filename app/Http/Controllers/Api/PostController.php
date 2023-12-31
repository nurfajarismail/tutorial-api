<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::with('writer:id,username')->get();

        $posts = Post::all();

        return PostDetailResource::collection($posts->loadMissing('writer', 'comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('file');
            $hashedName = $image->hashName(); // Hash nama file
            $image->storeAs('public/posts', $hashedName, 'public');
            $request['image'] = $hashedName;
        }

        $request['author'] = Auth::user()->id;

        $post = Post::create($request->all());

        return new PostDetailResource($post->loadMissing('writer', 'comments'));
        // return response()->json([]);
    }

    public function show($id)
    {

        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post);
    }

    public function update(Request $request, $id)
    {




        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer'));
    }

    public function destroy($id)
    {

        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer'));
    }
}
