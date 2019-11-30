<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        $threads = Thread::latest()->where('categoryName', $categoryName)->skip($skipAmt)->take(9)->get();
        $posts = [];
        foreach($threads as $t) {
            $id = $t->id;
            foreach(Post::where('thread', $id)->get() as $p) {
                if(array_key_exists($id, $posts)) {
                    $post = $posts[$t->id];
                    $time = Carbon::parse($p->created_at);
                    $timeCompare = Carbon::parse($post->created_at);
                    if($time->gt($timeCompare)) $posts[$t->id] = $post;
                } else $posts[$id] = $p;
            }
        }
        return view("category", ["category" => Category::All()->firstWhere('name', $categoryName), "threads" => $threads, "page" => $page, "posts" => $posts, "now" => Carbon::now()]);
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
        $userId = Auth::user()->id;
        $thread = new Thread();
        $thread->title = $title;
        $thread->op = $userId;
        $thread->posts = 1;
        $thread->categoryName = $category;
        $thread->save();
        $op = new Post();
        $op->thread = $thread->id;
        $op->contents = $text;
        $op->user = $userId;
        $op->save();
        return $thread->id;
    }

    /**
     * Show thread for $threadId
     * 
     * @param Request $request
     * @param String $categoryName
     * @param int $threadId
     * @return Response
     */
     public function showThread(Request $request, $categoryName, $threadId, $page) {
         $postCount = Post::where('thread', $threadId)->get()->count();
         $lastPage = floor(($postCount / 9));
         $skipAmt = $page > 1 ? $page * 9 : 0;
         $posts = Post::where('thread', $threadId)->skip($skipAmt)->take(9)->get();
         $isLastPage = ($page == $lastPage);
         $thread = Thread::find($threadId);
         $postsSize = sizeof($posts);
         $empty = ($postsSize == 0);
         return view('thread', ['lastPage' => $lastPage, 'empty' => $empty, 'page' => $page, 'posts' => $posts, 'isLastPage' => $isLastPage, 'thread' => $thread]);
     }
     
     /**
      * Post reply to $thread
      *
      * @param Request $request
      * @param int $threadId
      * @return Response
      */
      public function postReply(Request $request) {
          $post = new Post();
          $post->thread = $request->input('thread');
          $post->user = Auth::user()->id;
          $post->contents = $request->input('text');
          $post->save();
      }
      /**
       * Show user profile page
       * 
       * @param int $userId
       * @return Response
       */
      public function showUserProfile(Request $request, $userId) {
          $user = User::find($userId);
          if($user == null) return view('404');
          return view('profile', ['user' => $user]);
      }
}
