<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Thread;
use App\Models\Category;
use App\Models\Post;
use App\Models\Settings;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ForumController extends Controller
{

    public function __construct() {
        $this->middleware('update.last.login');
        $this->settings = Settings::first();
    }

    /**
     * Show threads of category by $categoryName and the $page of that category.
     * 
     * @param int $page
     * @param string $categoryName
     * @return Response
     */
    public function showCategory($category, $page) {
        $RESULTS_PER_PAGE = 9;
        $skipAmt = $page > 1 ? ($page * $RESULTS_PER_PAGE) - $RESULTS_PER_PAGE : 0;
        $categoryId = Category::where('name', str_replace('-', " ", $category))->first()->id;
        $threads = Thread::latest()->where('categoryId', $categoryId)->skip($skipAmt)->take($RESULTS_PER_PAGE)->get();
        $lastPage = ceil((sizeof($threads) / 9));
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
        return view("forum/category", ["lastPage" => $lastPage, "category" => Category::All()->firstWhere('id', $categoryId), "threads" => $threads, "page" => $page, "posts" => $posts, "now" => Carbon::now(), "settings" => Settings::first()]);
    }

     /**
     * Show the categories currently on the server.
     * 
     * @return Response
     */
    public static function showCategories() {
        $settings = Settings::first();
        Log::warning(asset('js'));
        return view("forum/categories", ["categories" => Category::All(), "color" => $settings->color, "editormode" => $settings->editormode]);
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
        if($desc == null) $desc = '';
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
        $categoryId = Category::where('name', str_replace("-", " ", $category))->first()->id;
        return view('forum/post', ['categoryURL' => $category, 'categoryId' => $categoryId, "settings" => Settings::first()]);
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
        $BANNED_CHARS = array("/", "\\", "#", "@", "~");
        if(Category::find($category) == null) {
            return false;
        }
        $settings = Settings::first();
        if(strlen($text) >= $settings->thread_post_length) {
            return false;
        }
        if(strlen($title) >= $settings->thread_title_length) {
            return false;
        }
        $titleContainsBannedChars = false;
        foreach($BANNED_CHARS as $c) {
            if(strpos($title, $c) !== false) {
                $titleContainsBannedChars = true;
            }
        }
        if($title != null && $text != null && $category != null && !$titleContainsBannedChars) {
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
            return str_replace(" ", "-", substr($thread->title, 0, 20)) . '-' . $thread->id;
        }
        return -1;
    }

    /**
     * Show thread for $threadId
     * 
     * @param Request $request
     * @param string $categoryName
     * @param string $thread
     * @return Response
     */
     public function showThread(Request $request, $categoryName, $thread, $page) {
         $exploded = explode("-", $thread);
         $threadId = $exploded[sizeof($exploded) - 1];
         $thread = Thread::find($threadId);
         if($thread == null) {
             return view('errors/404');
         }
         $postCount = Post::where('thread', $threadId)->get()->count();
         $lastPage = ceil(($postCount / 9));
         $skipAmt = $page > 1 ? $page * 9 : 0;
         $posts = Post::where('thread', $threadId)->skip($skipAmt-9)->take(9)->get();
         $isLastPage = ($page >= $lastPage);
         $postsSize = sizeof($posts);
         $empty = ($postsSize == 0);
         $threadLength = Settings::first()->thread_post_length;
         return view('forum/thread', ['settings' => Settings::first(), 'threadLength' => $threadLength, 'lastPage' => $lastPage, 'empty' => $empty, 'page' => $page, 'posts' => $posts, 'isLastPage' => $isLastPage, 'thread' => $thread, "color" => Settings::first()->color]);
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
          $settings = Settings::first();
          $text = $request->input('text');
          $threadId = $request->input('thread');
          if($settings->thread_post_length < strlen($text)) {
              return false;
          }
          if(Thread::find($threadId) == null) {
              return false;
          }
          $post->thread = $threadId;
          $post->user = Auth::user()->id;
          $post->contents = $text;
          $post->save();
      }
      /**
       * Show user profile page
       * 
       * @param Request $request
       * @param string $userId
       * @return Response
       */
      public function showUserProfile(Request $request, $userId) {
          $user = User::where('name', $userId)->first();
          if($user == null) {
              return view('errors/404');
          }
          $score = 0;
          $posts = Post::where('user', $user->id)->get();
          foreach($posts as $p) {
            if($p->liked_by != '') {
                $score += sizeof(unserialize($p->liked_by));
            }
          }
          $threads = Thread::where('op', $user->id)->count();
          $posts = (sizeof($posts) - $threads);
          return view('/profile/profile', ['threads' => $threads, 'posts' => $posts, 'score' => $score, 'user' => $user, "color" => Settings::first()->color]);
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
          if($post != null) {
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
      }
      /**
       * Delete a thread
       * 
       * @param Request $request
       */
      public function delThread(Request $request) {
          $threadId = $request->input('id');
          $thread = Thread::find($threadId);
          if($thread != null) {
          foreach(Post::where('thread', $thread->id)->get() as $p) {
            $p->delete();
          }
          $thread->delete();
        }
      }

      /**
       * Set erased on post's properties to !value.
       * 
       * @param Request $request
       */
      public function erasePost(Request $request) {
          $id = $request->id;
          $post = Post::find($id);
          if($post != null) {
          $post->erased = !$post->erased;
          $post->save();
          }
      }
    /**
    * Set locked on thread's properties to !value.
    * 
    * @param Request $request
    */
    public function lockThread(Request $request) {
        $id = $request->id;
        $thread = Thread::find($id);
        if($thread != null) {
        $thread->locked = !$thread->locked;
        $thread->save();
        }
    }
    /**
    * Ban user.
    * 
    * @param Request $request
    */
    public function banUser(Request $request) {
        $name = $request->user;
        $user = User::where('name', $name)->first();
        if($user != null) {
            $user->banned = 1;
            $user->save();
        }
    }

    /**
     * Query DB for conversation between 2 users.
     * 
     * @param Request $request
     */
    public function queryConversation(Request $request) {
        $u1 = $request->user1;
        $u2 = $request->user2;
        $u1Obj = User::find($u1);
        $u2Obj = User::find($u2);
        if($u1Obj == null || $u2Obj == null) {
            return null;
        }
        return $u1Obj->getConversation($u2);
    }

    /**
     * Mark Messages as read.
     * 
     * @param Request $request
     */
    public function markMessagesAsRead(Request $request) {
        $messageIDs = $request->json()->all();
        $conditions = [];
        foreach($messageIDs as $id) {
            array_push($conditions, ["id", "=", $id]);
        }
        Message::where($conditions)->update(['read' => '1']);
    }

    /**
     * Send a message.
     * 
     * @param Request $request
     */
    public function sendMessage(Request $request) {
        if(Auth::check()) {
            $userId = $request->user;
            $contents = $request->message;
            $user = User::where('name', $userId)->first();
            if($user != null && strlen($contents) <= $this->settings->message_length) {
                $message = new Message();
                $message->sender = Auth::user()->id;
                $message->recipient = $user->id;
                $message->contents = $contents;
                $message->id = 44;
                $message->save();
            }
        }
    }

    /**
     * Check if user exists in DB.
     * 
     * @param Request $request
     * 
     */
    public function userExists(Request $request) {
        if(!User::where('name', $request->username)->exists()) return "false";
        return "true";
    }
}