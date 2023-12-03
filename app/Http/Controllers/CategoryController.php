<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryToGroups;
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
    public function getCategory(?int $categoryId = null): JsonResponse
    {

        if ($categoryId != null) {
            $category = $this->getCategoryByID($categoryId);
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

    public function modifyCategory(int $categoryId, CategoryRequest $categoryInfo): JsonResponse
    {

        $category = $this->getCategoryByID($categoryId);

        $category->name = $categoryInfo->name ?? $category->name;
        $category->description = $categoryInfo->description ?? $category->description;

        if ($category->save()) {
            return $this->success(
                data: $category->toArray(),
                message: 'Category Updated',
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: 'Error in the category update',
            code: 500
        );
    }

    public function getCategoryGroups(int $categoryId, bool $returnArray = false): JsonResponse|array
    {

        $groups = CategoryToGroups::where("category_id", $categoryId)->get();

        $response = [];
        foreach ($groups as $key => $value) {
            $response[] = (new Group())->getGroupByID($value->group_id);
        }

        if ($returnArray) {
            return $response;
        }

        return $this->success(
            data: $response,
            message: '',
            code: 200
        );
    }

    public function addCategoryGroup(int $categoryId, int $groupId): JsonResponse
    {

        if (!$this->existCategory($categoryId)) {
            return $this->error(
                data: [],
                message: 'Unknow Category',
                code: 400
            );
        }

        if (!(new Group)->existGroup($groupId)) {
            return $this->error(
                data: [],
                message: 'Unknow Group',
                code: 400
            );
        }

        if ($this->isGroupAssociatedToCategory($categoryId, $groupId)) {
            return $this->error(
                data: [],
                message: 'Group already assocciated',
                code: 400
            );
        }


        $categoryToGroup = new CategoryToGroups();

        $categoryToGroup->category_id = $categoryId;
        $categoryToGroup->group_id = $groupId;

        if ($categoryToGroup->save()) {
            return $this->success(
                data: $this->getCategoryGroups($categoryId, true),
                message: "Group Associated",
                code: 200
            );
        }

        return $this->error(
            message: 'Error in the association',
            data: [],
            code: 500
        );
    }

    public function removeCategoryGroups(int $categoryId, int $groupId): JsonResponse
    {

        if (!$this->existCategory($categoryId)) {
            return $this->error(
                data: [],
                message: 'Unknow Category',
                code: 400
            );
        }

        if (!(new Group)->existGroup($groupId)) {
            return $this->error(
                data: [],
                message: 'Unknow Group',
                code: 400
            );
        }

        if (!$this->isGroupAssociatedToCategory($categoryId, $groupId)) {
            return $this->error(
                data: [],
                message: 'Group is not assocciated with this category',
                code: 400
            );
        }

        $result = CategoryToGroups::where( 'category_id', $categoryId )->where( 'group_id', $groupId )->delete();

        if( $result ) {
            return $this->success(
                data: [],
                message: 'Group removed',
                code: 200
            );
        }

        return $this->error(
            data: [],
            message: 'Error in the Group remove',
            code: 500
        );

    }




    private function isGroupAssociatedToCategory(int $categoryId, int $groupId): bool
    {
        $association = CategoryToGroups::where('category_id', $categoryId)->where('group_id', $groupId)->first();
        return $association == null ? false : true;
    }

    private function getCategoryByID(int $categoryId): Category|null
    {
        return Category::where('id', $categoryId)->first();
    }

    public function existCategory(int $categoryId): bool
    {
        $category = $this->getCategoryByID($categoryId);
        return ($category == null) ? false : true;
    }
}
