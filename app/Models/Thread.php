<?php

namespace App\Models;
use App\User;
use Eloquent;

class Thread extends Eloquent {
    
    public function markViewer($user) {
        $viewed_by = $this->viewed_by;
        $users = unserialize($viewed_by);
        $id = $user->id;
        if($users == null) {
            $users = Array($id);
            $this->viewed_by = serialize($users);
            $this->save();
        } else {
            if(!in_array($id, $users)) array_push($users, $id);
            $this->viewed_by = serialize($users);
            $this->save();
        }
    }

    public function getOP() {
        return User::find($this->op);
    }

    public function getMostRecentPost() {
        $posts = Post::where('thread', $this->id)->get();
        return $posts->last();
    }
}
