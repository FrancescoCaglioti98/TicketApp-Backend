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

    /**
     * Tutti gli utenti possono vedere le categorie, non solo gli amministratori
     * È importante per il fatto che le categorie sono la discriminante per l'apertura dei ticket
     */
    public function getCategory( ?int $categoryId = null)
    {

        if ($categoryId != null) {
            $category = $this->getCategoryByID( $categoryId );
        } else {
            $category = Category::all();
        }

        return $this->success(
            data: $category->toArray(),
            message: '',
            code: 200
        );

    }

    public function createCategory(CategoryRequest $categoryInfo): JsonResponse
    {

        $category = new Category();
        $category->name = $categoryInfo->name;
        $category->description = $categoryInfo->description ?? '';

        if ($category->save()) {
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

    private function getCategoryByID( int $categoryId ) : Category
    {
        return Category::where( 'id', $categoryId )->first();
    }
}
