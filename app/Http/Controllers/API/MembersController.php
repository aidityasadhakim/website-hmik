<?php

namespace App\Http\Controllers\API;

use App\Helpers\HttpStatus;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Members;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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
            $members = Members::where("department", $department)->join("departments", "members.department", "=", "departments.id")->get();

            if ($members) {
                return Response::success($members, "Members Retrieved", HttpStatus::$CREATED);
            } else {
                throw new Exception("Members Not Found");
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$NOT_ACCEPTABLE);
        }
    }

    public function updateMember(Request $request)
    {
        try {
            $updatedData = $request->validate([
                'name' => 'string|required|max:100',
                'description' => 'string|required|max:80',
                'department' => 'integer|required',
                'imgUrl' => 'string|required|max:255',
                'position' => 'string|required|max:80',
                'linkedin' => 'string|max:255|nullable',
                'instagram' => 'string|max:255|nullable',
                'github' => 'string|max:255|nullable',
            ]);
            $update = Members::where('id', $request->id)->update($updatedData);
            if ($update) {
                return Response::success($update, "Members Updated", HttpStatus::$CREATED);
            } else {
                throw new Exception("Members Update Failed");
            }
        } catch (Exception $th) {
            return Response::error($th->getMessage(), HttpStatus::$NOT_ACCEPTABLE);
        }
    }

    public function deleteMember($id)
    {
        try {
            $delete = Members::where('id', $id)->delete();
            if ($delete) {
                return Response::success(null, "Member Deleted Successfully", HttpStatus::$OK);
            } else {
                throw new Exception("Member Delete Failed");
            }
        } catch (Exception $th) {
            return Response::error($th->getMessage(), HttpStatus::$NOT_ACCEPTABLE);
        }
    }
}
