<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();

        return response()->json([
            'posts' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'content' => $post->content,
                    'image_path' => $post->image_path,
                    'user_id' => $post->user_id,
                    'is_owner' => $post->user_id === Auth::id(),
                    'user' => [
                        'name' => optional($post->user)->name ?: 'Usuário'
                    ],
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        $post->save();

        return response()->json([
            'message' => 'Post criado com sucesso!',
            'post' => [
                'id' => $post->id,
                'content' => $post->content,
                'image_path' => $post->image_path,
                'user_id' => $post->user_id,
                'is_owner' => true,
                'user' => [
                    'name' => Auth::user()->name
                ]
            ]
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Você não tem permissão para excluir este post.'], 403);
        }

        if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return response()->json(['message' => 'Post excluído com sucesso.']);
    }
}
