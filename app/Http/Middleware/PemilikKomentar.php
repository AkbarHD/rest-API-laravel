<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PemilikKomentar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user()->id;
        $comment = Comment::find($request->id);
        // dd($comment);
        if($comment->user_id != $user){
            return response()->json(['message' => 'Anda bikan pemilik komentar ini'], 401);
        }
        return $next($request);
    }
}
