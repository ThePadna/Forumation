<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ForumController extends Controller
{
    /**
     * Show the threads for the given page.
     * 
     * @param int $page
     * @return Response
     */
    public function showThreads($page) {
        $skipAmt = $page > 1 ? $page * 9 : 0;
        $threads = Thread::latest()->skip($skipAmt)->take(15)->get();
        return view("forum", ["threads" => $threads, "page" => $page]);
    }
}
