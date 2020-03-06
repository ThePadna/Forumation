<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Settings;

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

}