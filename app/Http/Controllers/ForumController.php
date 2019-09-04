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
     * @param string $category
     * @return Response
     */
    public function showThreads($category, $page) {
        $skipAmt = $page > 1 ? $page * 9 : 0;
        $threads = Thread::latest()->where('category', $category)->skip($skipAmt)->take(15)->get();
        return view("threads", ["category" => $category, "threads" => $threads, "page" => $page]);
    }

     /**
     * Show the categories currently on the server.
     * 
     * @return Response
     */
    public function showCategories() {
        return view("categories", ["categories" => Category::All()]);
    }
}
