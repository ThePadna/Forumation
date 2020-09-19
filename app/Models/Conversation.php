<?php

namespace App\Models;
use App\Models\Message;
use App\User;
use Illuminate\Support\Facades\Log;

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

    public function __toString() {
        $string = "";
        foreach($this->messages as $m) {
            $string .= User::find($m['sender'])->name . ":" . $m['contents'] . ":" . $m['id'] . ",";
        }
        $len = strlen($string);
        if($len > 0) $string = substr($string, 0, $len - 1);
        return $string;
    }

    public function getUnread() {
        $counter = 0;
        foreach($this->messages as $m) {
            if($m->recipientRead() == 0) $counter++;
        }
        return $counter;
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
        if(sizeof($this->messages) > 0) return $this->messages[sizeof($this->messages) - 1];
        else return null;
    }

    public static function addMessageToReleventConversation($m, $conversations) {
        Log::info("Adding message: {" . $m->sender . " : " . $m->recipient . "}");
        foreach($conversations as $c) {
            if($m->sender == $c->getUser2() || $m->recipient == $c->getUser2()) {
                if($m->recipient == $c->getUser1() || $m->sender == $c->getUser1()) {
                    Log::info("Adding message: {" . $m->sender . " : " . $m->recipient . "}" . "TO" . "conversation " . "{" . $c->getUser1() . " : " . $c->getUser2() . "}");
                    $c->push($m);
                    return true;
                }
            }
        }
        return false;
    }
}