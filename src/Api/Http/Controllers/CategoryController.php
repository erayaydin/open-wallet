<?php

namespace OpenWallet\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use OpenWallet\Api\Http\Requests\AccountCreateRequest;
use OpenWallet\Api\Http\Requests\AccountEditRequest;
use OpenWallet\Api\Http\Requests\CategoryCreateRequest;
use OpenWallet\Api\Http\Requests\CategoryEditRequest;
use OpenWallet\Api\Http\Resources\AccountResource;
use OpenWallet\Api\Http\Resources\CategoryResource;
use OpenWallet\Models\Account;
use OpenWallet\Models\Category;
use OpenWallet\Models\User;

class CategoryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return CategoryResource::collection($user->rootCategories()->paginate(20));
    }

    public function store(CategoryCreateRequest $request): CategoryResource
    {
        /** @var User $user */
        $user = $request->user();
        /** @var Category $category */
        $category = $user->categories()->make($request->validated());

        if ($request->has('parent')) {
            $category->parent()->associate($request->input('parent'));
        }

        $category->save();

        return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        $category->load('subs');

        return new CategoryResource($category);
    }

    public function update(CategoryEditRequest $request, Category $category): CategoryResource
    {
        if ($request->has('parent')) {
            $category->parent()->associate($request->input('parent'));
        }

        $category->update($request->validated());

        return new CategoryResource($category);
    }

    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent(status: 202);
    }
}
