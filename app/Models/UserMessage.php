<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $fillable = ['user_id', 'message', 'status'];

    // Some random processing logic, should be replaced with some other logic
    public function processMessage() {
        $this->result = md5($this->message);
    }
}
