<?php

namespace App\Http\Controllers\API;

use App\Helpers\HttpStatus;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Members;
use Exception;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function createMember(Request $request)
    {
        # Code ...

        try {
            $validatedData = $request->validate([
                'name' => 'string|required|max:255',
                'description' => 'string|required|max:255',
                'department' => 'string|required|max:255',
                'imgUrl' => 'string|required|max:255',
                'position' => 'string|required|max:255'
            ]);
            # code...
            $members = Members::create($validatedData);

            if ($members) {
                return Response::success($members, "Members created successfully", HttpStatus::$CREATED);
            } else {
                throw new Exception("Members creation failed");
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$NOT_ACCEPTABLE);
        }


        // $post = Post::create($validatedData);
    }

    public function showMembers(Request $request)
    {
        # code...
    }

    public function updateMember(Request $request)
    {
        # code...
    }

    public function deleteMember(Request $request)
    {
        # code...
    }
}
