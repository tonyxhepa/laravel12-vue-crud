<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        $post->image && Storage::disk('public')->delete($post->image);
        $post->delete();
        return to_route('posts.index')->with('success', 'Post deleted successfully');
    }
}
