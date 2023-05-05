<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $body = $request->getContent();
        $title = '';

        var_dump(request('category'));

        if (isset($body['category'])) {
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }

        if (isset($body['author'])) {
            $author = User::firstWhere('username', request('author'));
            $title = ' by ' . $author->name;
        }

        $posts = Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString();

        $data = [
            "posts" => $posts,
            "title" => $title
        ];

        if ($data['posts']) {
            return ApiFormatter::response(200, "Success", $data);
        } else {
            return ApiFormatter::response(404, "Not Found");
        }
    }

    public function show(Post $post)
    {
        return view('post', [
            "title" => "Single Post",
            "active" => 'posts',
            "post" => $post
        ]);
    }
}
