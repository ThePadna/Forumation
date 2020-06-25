<?php

namespace App\Models;
use Eloquent;

class Message extends Eloquent {

    public function __toString() {
        return $this->sender . ":" . $this->contents;
    }
}
