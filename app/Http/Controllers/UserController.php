<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Settings;
use App\Models\Rank;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Show profile editor page
     * 
     * @param Request $request
     * @param string $userId
     */
    public function editProfile(Request $request, $userId) {
        $user = User::where('name', $userId)->first();
        $settings = Settings::first();
        $ranks = Rank::all();
        if($user == null) return view('404');
        return view('profile/edit', ['ranks' => $ranks, 'user' => $user, "settings" => $settings]);
    }

    /**
     * Post updated fields for user profile
     * 
     * @param Request $request
     * @param string $userId
     */
    public function updateProfile(Request $request, $userId) {
        $file = $request->input('pic');
        $username = $request->input('username');
        $rank = $request->input('rank');
        $user = User::where('name', $userId)->first();
        $settings = Settings::first();
        if($user == null) {
            echo 'Invalid profile ID.';
            return;
        }
        if($rank != null) {
            $user->rank = $rank;
        }
        if($file != null) {
            $b64 = base64_encode($file);
            $user->avatar = $b64;
        }
        if($username != null && strlen($username) <= $settings->profile_name_length) {
            $user->name = $username;
        }
        $user->save();
        return $user->name;
    }
}