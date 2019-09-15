<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Category;

class ForumController extends Controller
{
    /**
     * Show the threads for the given page.
     * 
     * @param int $page
     * @param int $categoryId
     * @return Response
     */
    public function showThreads($categoryId, $page) {
        $skipAmt = $page > 1 ? $page * 9 : 0;
        $threads = Thread::latest()->where('categoryId', $categoryId)->skip($skipAmt)->take(15)->get();
        return view("threads", ["category" => Category::All()->firstWhere('id', $categoryId), "threads" => $threads, "page" => $page]);
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
        $categoryName = $request->input('categoryname');
        $category = new Category();
        $category->name = $categoryName;
        $category->save();
    }
}
