<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use Carbon\Carbon;
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
       * Show admin  
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

    public function canAccess() {
      return Auth::check() && Auth::user()->role == "admin";
    }

}