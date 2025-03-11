<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        $posts = auth()->user()->posts()->latest()->get();
        return Inertia::render('posts/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
