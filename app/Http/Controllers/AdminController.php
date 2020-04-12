<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use App\Models\Thread;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\Rank;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
     /**
       * Show admin control panel
       * 
       * @param Request $request
       * @return Response
       */
      public function showCtrlPanel(Request $request) {
        if(!$this->canAccess()) return view('errors/noaccess');
        $settings = Settings::first();
        return view('admin/admin', ['settings' => $settings]);
      }

      /**
       * Show admin users page.
       * 
       * @param int page
       * @param Request $request
       * @return Response
       */
      public function showUsers(Request $request, $page) {
        if(!$this->canAccess()) return view('errors/noaccess');
        $RESULTS_PER_PAGE = 20;
        $skipAmt = $page > 1 ? ($page * $RESULTS_PER_PAGE) - $RESULTS_PER_PAGE : 0;
        $users = User::latest()->skip($skipAmt)->take($RESULTS_PER_PAGE)->get();
        $settings = Settings::first();
        return view('admin/users', ["page" => $page, "users" => $users, "settings" => $settings]);
      }
      /**
       * Show admin threads page.
       * 
       * @param int page
       * @param Request $request
       * @return Response
       */
      public function showThreads(Request $request, $page) {
        if(!$this->canAccess()) return view('errors/noaccess');
        $RESULTS_PER_PAGE = 20;
        $skipAmt = $page > 1 ? ($page * $RESULTS_PER_PAGE) - $RESULTS_PER_PAGE : 0;
        $threads = Thread::latest()->skip($skipAmt)->take($RESULTS_PER_PAGE)->get();
        $settings = Settings::first();
        return view('admin/threads', ["page" => $page, "threads" => $threads, "settings" => $settings]);
      }
      /**
       * Show admin posts page.
       * 
       * @param int page
       * @param Request $request
       * @return Response
       */
      public function showPosts(Request $request, $page) {
        if(!$this->canAccess()) return view('errors/noaccess');
        $RESULTS_PER_PAGE = 20;
        $skipAmt = $page > 1 ? ($page * $RESULTS_PER_PAGE) - $RESULTS_PER_PAGE : 0;
        $posts = Post::latest()->skip($skipAmt)->take($RESULTS_PER_PAGE)->get();
        $settings = Settings::first();
        return view('admin/posts', ["page" => $page, "posts" => $posts, "settings" => $settings]);
      }

    /**
     * Show admin data management page
     * 
     * @param Request $request
     */
    public function showDataManagement(Request $request) {
        if(!$this->canAccess()) return view('errors/noaccess');
        $settings = Settings::first();
        return view('admin/datamanagement', ['settings' => $settings]);
    }

    /**
       * Post color change to SQL Settings.
       * 
       * @param Request $request
       */
      public function postColorUpdate(Request $request) {
        if(!$this->canAccess()) return view('errors/noaccess');
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
      if(!$this->canAccess()) return view('errors/noaccess');
      $settings = Settings::first();
      if($settings == null) {
          $settings = new Settings();
      }
      $settings->editormode = $request->input('toggle');
      $settings->save();
    }

    /**
     * Query DB for users based on $val
     * 
     * @param Request $request
     */
    public function queryUsers(Request $request) {
      if(!$this->canAccess()) return view('errors/noaccess');
      $val = $request->input('val');
      $users = User::where('name', 'LIKE', '%' . $val . '%')->take(15)->get();
      $usersSerialized = array();
      foreach($users as $u) {
        $userData = array($u->name, Carbon::parse($u->created_at)->format('Y-m-d H:i:s'), Carbon::parse($u->updated_at)->format('Y-m-d H:i:s'));
        array_push($usersSerialized, $userData);
      }
      return json_encode($usersSerialized);
    }
     /**
     * Query DB for threads based on $val
     * 
     * @param Request $request
     */
    public function queryThreads(Request $request) {
      if(!$this->canAccess()) return view('errors/noaccess');
      $val = $request->input('val');
      $threads = Thread::where('title', 'LIKE', '%' . $val . '%')->take(15)->get();
      $threadsSerialized = array();
      foreach($threads as $t) {
        $threadData = array($t->title, Carbon::parse($t->created_at)->format('Y-m-d H:i:s'), Carbon::parse($t->updated_at)->format('Y-m-d H:i:s'));
        array_push($threadsSerialized, $threadData);
      }
      return json_encode($threadsSerialized);
    }
     /**
     * Query DB for users based on $val
     * 
     * @param Request $request
     */
    public function queryPosts(Request $request) {
      if(!$this->canAccess()) return view('errors/noaccess');
      $val = $request->input('val');
      $posts = Post::where('contents', 'LIKE', '%' . $val . '%')->take(15)->get();
      $postsSerialized = array();
      foreach($posts as $p) {
        $postData = array($p->contents, Carbon::parse($p->created_at)->format('Y-m-d H:i:s'), Carbon::parse($p->updated_at)->format('Y-m-d H:i:s'));
        array_push($postsSerialized, $postData);
      }
      return json_encode($postsSerialized);
    }

    /**
     * Update thread settings
     * 
     * @param Request $request
     */
    public function updateThreadSettings(Request $request) {
      if(!$this->canAccess()) return view('errors/noaccess');
      $postLen = $request->input('postLength');
      $opLen = $request->input('opLength');
      $titleLen = $request->input('titleLength');
      $settings = Settings::first();
      $settings->thread_title_length = $titleLen;
      $settings->thread_op_length = $opLen;
      $settings->thread_post_length = $postLen;
      $settings->save();
    }

    /**
     * Update ranks based on edits.
     * 
     * @param Request $request
     */
    public function updateRanks(Request $request) {
      if(!$this->canAccess()) return view('errors/noaccess');
      $json = $request->input('ranks');
      $json = json_decode($json, true);
      foreach($json as $r) {
        $color = $r['color'];
        $perms = $r['perms'];
        $name = $r['name'];
      }
    }

    /**
     * Show rank editor page.
     * 
     * @param Request $request
     */
    public function showRanks(Request $request) {
      if(!$this->canAccess()) return view('errors/noaccess');
      return view('admin/ranks', ['settings' => Settings::first(), 'ranks' => Rank::all()]);
    }
    public function canAccess() {
      return Auth::check() && Auth::user()->role == "admin";
    }

}