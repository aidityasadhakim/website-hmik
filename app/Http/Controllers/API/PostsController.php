<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Helpers\Response;
use App\Helpers\HttpStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     tags={"posts"},
     *     summary="Get All Posts",
     *     description="This API Retrieves all posts from all users, can be filtered by author and category or even both",
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

        $posts = Post::with('subCategories')->latest()->filter(request(['search', 'category', 'author', 'sub_category']))->get();

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
     *     @OA\Parameter(
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
    }

    /**
     * @OA\Post(
     *     path="/api/posts/create",
     *     description="This API allows you to create a new post",
     *     summary="Create a new post",
     *     operationId="store",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Post"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Post Created",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *      tags={
     *          "posts"
     *          }
     * )
     * */

    public function store(Request $request)
    {
        try {
            $findPost = Post::where('slug', $request->slug)->first();
            if ($findPost) {
                throw new Exception("Post is already exist", HttpStatus::$BAD_REQUEST);
            }
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'slug' => 'required|unique:posts',
                'category_id' => 'required',
                'image' => 'required|max:1024',
                'body' => 'required',
                'user_id' => 'required',
                'sub_category_id' => 'required'
            ]);

            // $validatedData['user_id'] = auth()->user()->id;
            $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

            $post = Post::create($validatedData);

            if ($post) {
                return Response::success($post, "Post Created", HttpStatus::$CREATED);
            } else {
                return Response::error("BAD REQUEST", HttpStatus::$BAD_REQUEST);
            }
        } catch (\Throwable $e) {
            if ($e->getCode() != 0) {
                return Response::error($e->getMessage(), $e->getCode());
            } else {
                return Response::error($e->getMessage(), 500);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/api/posts/update/{slug}",
     *     description="This API allows you to update a new post",
     *     summary="Update a new post",
     *     operationId="update",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/Post"),
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Post Updated",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *      tags={
     *          "posts"
     *          }
     * )
     * */

    public function update(Request $request, $slug)
    {
        try {
            $rules = [
                'title' => 'required|max:255',
                'category_id' => 'required',
                'image' => 'required',
                'body' => 'required',
                'user_id' => 'required',
            ];

            $validatedData = $request->validate($rules);

            $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

            $updatedPost = Post::where('slug', $slug)
                ->update($validatedData);

            if ($updatedPost) {
                return Response::success($updatedPost, "Post Updated", HttpStatus::$CREATED);
            } else {
                return Response::error("Post Update Failed", HttpStatus::$BAD_REQUEST);
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/posts/delete/{slug}",
     *     description="This API allows you to delete a new post",
     *     summary="Delete a new post",
     *     operationId="destroy",
     *     security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *      tags={
     *          "posts"
     *          }
     * )
     * */

    public function destroy(Post $post)
    {
        try {
            $destroyedPost = Post::destroy($post->id);
            if ($destroyedPost) {
                return Response::success($destroyedPost, "Post Destroyed", HttpStatus::$OK);
            } else {
                return Response::error("Post Delete Failed", HttpStatus::$BAD_REQUEST);
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$BAD_REQUEST);
        }
    }
}
