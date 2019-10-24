<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Post;
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
        $categoryName = $request->input('categoryTitle');
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

    /**
     * Show the form to submit a new Thread on current category.
     * 
     * @param Request $request
     * @return Response
     */
    public function showThreadPostForm(Request $request, $category) {
        return view('post', ['categoryName' => $category]);
    }

    /**
     * Post a thread to desired category.
     * 
     * @param Request $request
     * @param String $categoryName
     */
    public function postThread(Request $request) {
        $title = $request->input('threadTitle');
        $text = $request->input('threadText');
        $category = $request->input('categoryName');
        $userUUID = Auth::user()->uuid;
        $thread = new Thread();
        $thread->title = $title;
        $thread->op = $userUUID;
        $thread->posts = 1;
        $thread->categoryName = $category;
        $thread->save();
        return $request->path();
        $op = new Post();
        $op->thread = $thread->id;
        $op->contents = $text;
        $op->user = $userUUID;
        $op->save();
    }

    /**
     * Show thread for $threadId
     * 
     * @param Request $request
     * @param String $categoryName
     * @param int $threadId
     * @return Response
     */
     public function showThread(Request $request, $categoryName, $threadId) {
         //return posts
     }
}
