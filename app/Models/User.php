<?php

namespace App\Models;
use Eloquent;

class User extends Eloquent {
    protected $fillable = ["name", "email", "password"];
}
