<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostrResource;
use App\Models\Post;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
    {
        // $post = Post::all(); // jika tdk menggunakan tabel user sbg relasi
        // $post = Post::with(['User:id,username,email'])->get();
        // with sama loadmissing sama
        // $post = Post::with(['User:id,username,email,lastname'])->get()->loadMissing('User:id,username,email,lastname');
        $post = Post::get();
        // return response()->json(['data' => $post]); // ini manual

        // kalo mnggnkn ini bisa custom sesuka hati
        return PostrResource::collection($post->loadMissing(['User:id,username,email,lastname', 'Comments:id,post_id,user_id,comments_content'])); // otomatis tanpa di kasih key "data" dia sdh generetae sendiri
    }

    public function show($id)
    {
        $post = Post::with('User:id,username,email,password,lastname,firstname')->find($id);
        // return response()->json(['data' => $post]);
        if(!$post){
            return response()->json(['message' => 'Data tidak ditemukan']);
        }

        // ini sbernya juga bsua menggunakan PostResource, cmn karena saya ingin membedakan dari segi api jadi menggunakan PostDetailResource
        return new PostDetailResource($post); // kalo 1 data dia tdk perlu collection dan perlu ditambahkan new
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        $validated['author'] = auth()->user()->id;
        $validated['title'] = $request->title;
        $validated['news_content'] = $request->news_content;
        $post = Post::create($validated);
        return new PostDetailResource($post->loadMissing('User:id,username,email')); // $post->loadMissing('User:id,username,email' utk menampilkan ketika kita berhasil bikin berita
    }

    public function update(Request $request, $id)
    {
        // kita ga pengen user lain tidak boleh mengupdate data yang bukan miliknya
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        $post = Post::find($id);
        $post->update($request->all()); // kalo request all itu semuanya di update
        return new PostDetailResource($post->loadMissing('User:id,username,email')); // $post->loadMissing('User:id,username,email' utk menampilkan ketika kita berhasil bikin berita
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('User:id,username,email'));
    }
}
