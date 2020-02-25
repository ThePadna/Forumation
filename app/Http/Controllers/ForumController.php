<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Post;
use App\Models\Settings;
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
    public function showCategory($categoryId, $page) {
        $skipAmt = $page > 1 ? ($page * 9) - 9 : 0;
        $threads = Thread::latest()->where('categoryId', $categoryId)->skip($skipAmt)->take(9)->get();
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
        return view("category", ["category" => Category::All()->firstWhere('id', $categoryId), "threads" => $threads, "page" => $page, "posts" => $posts, "now" => Carbon::now(), "color" => Settings::first()->color]);
    }

     /**
     * Show the categories currently on the server.
     * 
     * @return Response
     */
    public function showCategories() {
        $settings = Settings::first();
        return view("categories", ["categories" => Category::All(), "color" => $settings->color, "editormode" => $settings->editormode]);
    }

    /**
     * Post a new category to the database.
     * 
     * @param Request $request
     */
    public function postCategory(Request $request) {
        $categoryName = $request->input('categoryTitle');
        $categoryDesc = $request->input('categoryDesc');
        $category = new Category();
        $category->name = $categoryName;
        $category->desc = $categoryDesc;
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
        $id = $request->input('id');
        Category::find($id)->delete();
        $threads = Thread::where('categoryId', $id)->get();
        foreach($threads as $t) {
            $posts = Post::where('thread', $t->id)->get();
            foreach($posts as $p) {
                $p->delete();
            }
            $t->delete();
        }
    }

    /**
     * Edit a category's name on the database.
     * 
     * @param Request $request
     */
    public function editCategory(Request $request) {
        $id = $request->input('id');
        $new = $request->input('newCategoryName');
        $desc = $request->input('description');
        $cat = Category::find($id);
        $cat->desc = $desc;
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
        return view('post', ['categoryId' => $category, "color" => Settings::first()->color]);
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
        $category = $request->input('categoryId');
        if($title != null && $text != null && $category != null) {
            $userId = Auth::user()->id;
            $thread = new Thread();
            $thread->title = $title;
            $thread->op = $userId;
            $thread->posts = 1;
            $thread->categoryId = $category;
            $thread->viewed_by = serialize(Array($userId));
            $thread->save();
            $op = new Post();
            $op->thread = $thread->id;
            $op->contents = $text;
            $op->user = $userId;
            $op->save();
            return $thread->id;
        }
        return -1;
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
         $isLastPage = ($page >= $lastPage);
         $thread = Thread::find($threadId);
         $postsSize = sizeof($posts);
         $empty = ($postsSize == 0);
         return view('thread', ['lastPage' => $lastPage, 'empty' => $empty, 'page' => $page, 'posts' => $posts, 'isLastPage' => $isLastPage, 'thread' => $thread, "color" => Settings::first()->color]);
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
       * @param Request $request
       * @param int $userId
       * @return Response
       */
      public function showUserProfile(Request $request, $userId) {
          $user = User::find($userId);
          $score = $user->points;
          $posts = Post::where('user', $user->id)->get()->count();
          $threads = Thread::where('op', $user->id)->get()->count();
          $posts = ($posts - $threads);
          return view('profile', ['threads' => $threads, 'posts' => $posts, 'score' => $score, 'user' => $user, "color" => Settings::first()->color]);
      }
      /**
       * Show admin control panel
       * 
       * @param Request $request
       * @return Response
       */
      public function showCtrlPanel(Request $request) {
          //checks
          $settings = Settings::first();
          return view('admin', ['settings' => $settings]);
      }
      /**
       * Post color change to SQL Settings.
       * 
       * @param Request $request
       */
      public function postColorUpdate(Request $request) {
          $settings = Settings::first();
          if($settings == null) {
              $settings = new Settings();
          }
          $settings->color = $request->input('color');
          $settings->save();
      }
      /**
       * Post editor mode update to SQL Settings.
       * 
       * @param Request $request
       */
      public function postEditorModeUpdate(Request $request) {
        $settings = Settings::first();
        if($settings == null) {
            $settings = new Settings();
        }
        $settings->editormode = $request->input('toggle');
        $settings->save();
      }

      /**
       * Post a like or unlike to post
       * 
       * @param Request $request
       */
      public function likePost(Request $request) {
          $liked = $request->input('liked');
          $postId = $request->input('id');
          $post = Post::find($postId);
          $liked_users = unserialize($post->liked_by);
          if($liked_users == null) $liked_users = Array();
          $userId = Auth::user()->id;
          if($liked == 0) {
            if(in_array($userId, $liked_users)) {
                $index = array_search($userId, $liked_users);
                unset($liked_users[$index]);
            }
          } else {
            if(!in_array($userId, $liked_users)) array_push($liked_users, $userId);
          }
          $post->liked_by = serialize($liked_users);
          $post->save();
          return sizeof($liked_users);
      }

      /**
       * Delete a thread
       * 
       * @param Request $request
       */
      public function delThread(Request $request) {
          $threadId = $request->input('id');
          $thread = Thread::find($threadId);
          $thread->delete();
      }
}
