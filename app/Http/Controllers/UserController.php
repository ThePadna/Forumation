<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    /**
     * Show profile editor page
     * 
     * @param Request $request
     * @param int $userId
     */
    public function editProfile(Request $request, $userId) {
        $user = User::find($userId);
        if($user == null) return view('404');
        return view('profile/edit', ['user' => $user]);
    }

    /**
     * Post updated fields for user profile
     * 
     * @param Request $request
     */
    public function updateProfile(Request $request, $userId) {
        $file = $request->input('pic');
        $username = $request->input('username');
        $user = User::find($userId);
        if($file != null) {
            $b64 = base64_encode($file);
            $user->avatar = $b64;
        }
        if($username != null) {
            $user->name = $username;
        }
        $user->save();
    }
}