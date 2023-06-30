<?php

namespace App\Http\Controllers\API;

use App\Helpers\HttpStatus;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function showAllCategory()
    {
        try {
            $category = Category::all();
            return Response::success($category, "Category Retrieved", HttpStatus::$OK);
        } catch (\Throwable $e) {
            # code...
            if ($e->getCode()) {
                return Response::error($e->getMessage(), $e->getCode());
            } else {
                return Response::error($e->getMessage(), 500);
            }
        }
    }

    function showAllSubCategory()
    {
        try {
            $subCategory = SubCategories::all();
            return Response::success($subCategory, "Sub Category Retrieved", HttpStatus::$OK);
        } catch (\Throwable $e) {
            if ($e->getCode() != 0) {
                return Response::error($e->getMessage(), $e->getCode());
            } else {
                return Response::error($e->getMessage(), 500);
            }
        }
    }
}
