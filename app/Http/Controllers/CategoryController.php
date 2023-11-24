<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    use HttpResponses;

    public function createCategory( CategoryRequest $categoryInfo ) : JsonResponse
    {

        $category = new Category();
        $category->name = $categoryInfo->name;
        $category->description = $categoryInfo->description ?? '';

        if( $category->save() ) {
            return $this->success(
                data: $category->toArray(),
                message: 'Category Created',
                code: 200
            );
        }
        
        return $this->error(
            data: [],
            message: "Error in the category creation",
            code: 500
        );    
    }



}
