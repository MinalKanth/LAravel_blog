<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function viewpostsindex()
    {
        $posts = Post::latest()->approved()->published()->paginate(6);
        // $posts = Post::latest()->paginate(6);
        return view('posts',compact('posts'));
    }
    public function viewpostsdetails($slug)
    {
        $post = Post::where('slug',$slug)->approved()->published()->first();
        // $post = Post::where('slug',$slug)->first();

        $blogKey = 'blog_' . $post->id;

        if (!Session::has($blogKey)) {
            $post->increment('view_count');
            Session::put($blogKey,1);
        }
        $randomposts = Post::approved()->published()->take(3)->inRandomOrder()->get();
        // $randomposts = Post::take(3)->inRandomOrder()->get();
        return view('post',compact('post','randomposts'));

    }

    public function postByCategory($slug)
    {
        $category = Category::where('slug',$slug)->first();
        $posts = $category->posts()->approved()->published()->get();
        // $posts = $category->posts()->get();
        return view('category',compact('category','posts'));
    }

    public function postByTag($slug)
    {
        $tag = Tag::where('slug',$slug)->first();
        $posts = $tag->posts()->approved()->published()->get();
        // $posts = $tag->posts()->get();
        return view('tag',compact('tag','posts'));
    }
}
