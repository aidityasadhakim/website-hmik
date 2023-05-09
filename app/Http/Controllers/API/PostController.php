<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\HttpStatus;
use Exception;

class PostController extends Controller
{
    public function index(Request $request)
    {
        var_dump(request('category'));

        $title = '';
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            if ($category) {
                $categoryName = $category->name;
            }
        }

        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            if ($author) {
                $authorName = $author->name;
            }
        }

        $posts = Post::latest()->filter(request(['search', 'category', 'author']))->get();

        $data = [
            "category" => $categoryName ?? null,
            "count" => $posts->count(),
            "author" => $authorName ?? null,
            "posts" => $posts
        ];

        if ($data) {
            return Response::success($data, "All Post Retrieved", HttpStatus::$OK);
        } else {
            return Response::error(HttpStatus::$NOT_FOUND, "No Post Found");
        }
    }

    public function show($slug)
    {
        try {
            $post = Post::where('slug', $slug)->firstOrFail();
            return Response::success($post, "Post Retrieved", HttpStatus::$OK);
        } catch (Exception $e) {
            return Response::error("No Post Found", HttpStatus::$NOT_FOUND);
        }
        // return view('post', [
        //     "title" => "Single Post",
        //     "active" => 'posts',
        //     "post" => $post
        // ]);
    }
}
