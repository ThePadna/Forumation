<?php

namespace App\Models;

/**
 * Wrapper class for user conversation data.
 */
class Conversation {

    private $messages = [];
    private $user1 = null;
    private $user2 = null;

    public function __construct($m1, $m2, $messages) {
        $this->user1 = $m1;
        $this->user2 = $m2;
        $this->messages = $messages;
    }

    public function getUser1() {
        return $this->user1;
    }

    public function getUser2() {
        return $this->user2;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function push($m) {
        array_push($this->messages, $m);
    }

    public function getLatest() {
        return $this->messages[sizeof($this->messages) - 1];
    }

    public static function addMessageToReleventConversation($m, $conversations) {
        foreach($conversations as $c) {
            if($m->sender === $c->getUser1() || $m->sender === $c->getUser2()
             && $m->recipient === $c->getUser1() || $m->recipient === $c->getUser2()) {
                $c->push($m);
                return true;
            }
        }
        return false;
    }
}