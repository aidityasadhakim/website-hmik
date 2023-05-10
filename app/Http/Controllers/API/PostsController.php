<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Helpers\Response;
use App\Helpers\HttpStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     tags={"posts"},
     *     summary="Get All Posts",
     *     description="This API Retrieves all posts from all users",
     *     operationId="index",
     * @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="Author to filter by",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Category to filter by",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Posts Retrieved",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No Posts Found",
     *     )
     * )
     */

    public function index(Request $request)
    {

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

    /**
     * @OA\Get(
     *     path="/api/posts/{slug}",
     *     tags={"posts"},
     *     summary="Get Single Posts",
     *     description="This API Retrieves single posts",
     *     operationId="show",
     * @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Posts Retrieved",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No Posts Found",
     *     )
     * )
     */
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
