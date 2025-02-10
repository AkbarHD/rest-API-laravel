<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comments_content' => 'required',
            'post_id' => 'required|exists:posts,id'
        ]);

        $comment = Comment::create([
            'comments_content' => $request->comments_content,
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id
        ]);

        // return response()->json($comment); // ga pake resource juga bisa, cmn tdk bisa di custom
        // return response()->json($comment->loadMissing(['Comentator']));
        return new CommentResource($comment->loadMissing(['Comentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comments_content' => 'required',
        ]);
        $comment = Comment::find($id);

        $comment->update([
            'comments_content' => $request->comments_content
        ]);
        return new CommentResource($comment->loadMissing(['Comentator:id,username']));
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return new CommentResource($comment->loadMissing(['Comentator:id,username']));
    }
}
