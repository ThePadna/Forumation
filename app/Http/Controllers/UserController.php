<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Settings;
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
        if($user == null) return view('404');
        return view('profile/edit', ['user' => $user, "color" => Settings::first()->color]);
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
        $user = User::where('name', $userId)->first();
        if($user == null) {
            echo 'Invalid profile ID.';
            return;
        }
        if($file != null) {
            $b64 = base64_encode($file);
            $user->avatar = $b64;
        }
        if($username != null) {
            $user->name = $username;
        }
        $user->save();
        return $user->name;
    }
}