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
        $threads = Thread::all();
        return view("forum", ["threads" => $threads]);
    }
}
