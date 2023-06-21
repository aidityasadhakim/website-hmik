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
        try {
            $validatedData = $request->validate([
                'name' => 'string|required|max:100',
                'description' => 'string|required|max:80',
                'department' => 'integer|required',
                'imgUrl' => 'string|required|max:255',
                'position' => 'string|required|max:80',
                'linkedin' => 'string|max:255|nullable',
                'instagram' => 'string|max:255|nullable',
                'github' => 'string|max:255|nullable',
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

    public function showMemberByDepartment($department)
    {
        try {
            $members = Members::join("departments", "members.department", "=", "departments.id")
                ->where("department", $department)
                ->selectRaw("members.*, departments.name as departmentName")
                ->get();

            if ($members) {
                return Response::success($members, "Members Retrieved", HttpStatus::$CREATED);
            } else {
                throw new Exception("Members Not Found");
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$NOT_ACCEPTABLE);
        }
    }

    public function showMemberByName($name, $departments)
    {
        var_dump([$name, $departments]);
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
