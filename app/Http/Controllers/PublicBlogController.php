<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = 'a';
        $tags = 'a';
        return view('public-blog.blog.blog-new', compact('posts', 'tags'));
    }



    public function show($slug)
    {
        $tags = 'xxx';
        $post = 'ax';

        return view('public-blog.blog.detail', compact('post', 'tags'));
    }
}
