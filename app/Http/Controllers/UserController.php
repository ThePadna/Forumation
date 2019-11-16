<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    /**
     * Show profile editor page
     * 
     * 
     */
    public function editProfile(Request $request, $userId) {
        $user = User::find($userId);
        if($user == null) return view('404');
        return view('profile/edit', ['user' => $user]);
    }
}