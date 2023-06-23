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
    /**
     * @OA\Post(
     *    path="/api/members/create",
     *    description="This API will create a new member",
     *    summary="Create a new member",
     *    operationId="createMember",
     *    security={{"bearerAuth":{}}},
     *
     *    @OA\RequestBody(
     *        description="Create Member Payload",
     *        required=true,
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(ref="#/components/schemas/Members"),
     *        ),
     *    ),
     *    @OA\Response(
     *      response="200",
     *      description="User Created",
     *      @OA\Schema(ref="#/components/schemas/ApiResponse")    
     *    ),
     *    @OA\Response(
     *      response="400",
     *      description="Bad Request",
     *      @OA\Schema(ref="#/components/schemas/ApiResponse")
     *    ),
     *    tags={
     *          "members"
     *      }
     *)
     */
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

    /**
     * @OA\Post(
     *    path="/api/members/update/{id}",
     *    description="This API will update",
     *    summary="Update a member",
     *    operationId="updateMember",
     *    security={{"bearerAuth":{}}},
     * 
     *    @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *    @OA\RequestBody(
     *        description="Create Member Payload",
     *        required=true,
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(ref="#/components/schemas/Members"),
     *        ),
     *    ),
     *    @OA\Response(
     *      response="200",
     *      description="User Updated",
     *      @OA\Schema(ref="#/components/schemas/ApiResponse")    
     *    ),
     *    @OA\Response(
     *      response="400",
     *      description="Bad Request",
     *      @OA\Schema(ref="#/components/schemas/ApiResponse")
     *    ),
     *    tags={
     *          "members"
     *      }
     *)
     */

    public function updateMember(Request $request, $id)
    {
        try {
            try {
                $rules = $request->validate([
                    'name' => 'string|required|max:255',
                    'description' => 'string|required|max:255',
                    'department' => 'string|required|max:255',
                    'imgUrl' => 'string|required|max:255',
                    'position' => 'string|required|max:255',
                    'linkedin' => 'string|max:255|nullable',
                    'instagram' => 'string|max:255|nullable',
                    'github' => 'string|max:255|nullable'
                ]);
                $member = Members::find($id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            $isUpdate = $member->update($rules);

            return Response::success($isUpdate, "Member has been updated", HttpStatus::$OK);
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$NOT_FOUND);
        }
    }

    public function deleteMember(Request $request)
    {
        # code...
    }
}
