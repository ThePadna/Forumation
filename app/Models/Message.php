<?php

namespace App\Models;
use Eloquent;

class Message extends Eloquent {

    public function __toString() {
        return $this->sender . ":" . $this->contents;
    }

    public function getSender() {
        return $this->sender;
    }

    public function getContents() {
        return $this->contents;
    }

    public function getRecipient() {
        return $this->recipient;
    }

    public function recipientRead() {
        return $this->read;
    }
}
