<?php

namespace App\Models;
use Eloquent;

class Rank extends Eloquent {
    
    public function hasPerm($perm) {
        $perms = unserialize($this->permissions);
        if(in_array($perm, $perms)) return true;
        else return false;
    }
}
