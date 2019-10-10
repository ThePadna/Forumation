<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class ForumController extends Controller
{
    /**
     * Show threads of category by $categoryName and the $page of that category.
     * 
     * @param int $page
     * @param string $categoryName
     * @return Response
     */
    public function showCategory($categoryName, $page) {
        $skipAmt = $page > 1 ? $page * 9 : 0;
        $threads = Thread::latest()->where('categoryName', $categoryName)->skip($skipAmt)->take(15)->get();
        return view("category", ["category" => Category::All()->firstWhere('name', $categoryName), "threads" => $threads, "page" => $page]);
    }

     /**
     * Show the categories currently on the server.
     * 
     * @return Response
     */
    public function showCategories() {
        return view("categories", ["categories" => Category::All()]);
    }

    /**
     * Post a new category to the database.
     * 
     * @param Request $request
     */
    public function postCategory(Request $request) {
        $categoryName = $request->input('categoryName');
        $category = new Category();
        $category->name = $categoryName;
        $category->save();
    }

    /**
     * Switch IDs of categories on the database.
     * 
     * @param Request $request
     */
    public function categorySwitchId(Request $request) {
        $id1 = $request->input('draggedId');
        $id2 = $request->input('targetId');
        $cat1 = Category::find($id1);
        $cat2 = Category::find($id2);
        $cat1name = $cat1->name;
        $cat1->name = $cat2->name;
        $cat1->save();
        $cat2->name = $cat1name;
        $cat2->save();
    }

    /**
     * Delete a category on the database.
     * 
     * @param Request $request
     */
    public function delCategory(Request $request) {
        $categoryName = $request->input('categoryName');
        Category::where('name', $categoryName)->delete();
        return $categoryName;
    }

    /**
     * Edit a category's name on the database.
     * 
     * @param Request $request
     */
    public function editCategory(Request $request) {
        $old = $request->input('categoryName');
        $new = $request->input('newCategoryName');
        $cat = Category::where('name', $old)->first();
        $cat->name = $new;
        $cat->save();
    }
}
