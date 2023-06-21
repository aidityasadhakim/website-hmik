<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Helpers\Response;
use App\Models\Departments;
use App\Helpers\HttpStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|required|max:100',
                'slug' => 'string|required|max:80',
            ]);
            # code...
            $department = Departments::create($validatedData);

            if ($department) {
                return Response::success($department, "department created successfully", HttpStatus::$CREATED);
            } else {
                throw new Exception("department creation failed");
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$NOT_ACCEPTABLE);
        }
    }
}
