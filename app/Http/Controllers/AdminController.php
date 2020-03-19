<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;

class AdminController extends Controller
{
     /**
       * Show admin control panel
       * 
       * @param Request $request
       * @return Response
       */
      public function showCtrlPanel(Request $request) {
        //checks
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
        $settings = Settings::first();
        return view('admin/datamanagement', ['settings' => $settings]);
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
     * Query DB for users based on $val
     * 
     * @param Request $request
     */
    public function queryUsers(Request $request) {
      $val = $request->input('val');
      $users = User::where('name', 'LIKE', '%' . $val)->get();
      $usersSerialized = '';
      foreach($users as $u) {
        $usersSerialized = $usersSerialized . ' ' . $u->name;
      }
      return $usersSerialized;
    }

}