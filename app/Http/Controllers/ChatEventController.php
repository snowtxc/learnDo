<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatEventController implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $from_user_id;
    public $to_user_id;
    public $data;


    public function __construct($from_user_id, $to_user_id, $message)
    {
        $this->from_user_id = $from_user_id;
        $this->to_user_id = $to_user_id;
        $this->message = $message;
    }
   
    public function broadcastOn()
    {
        return "MessageFrom-$this->from_user_id-To-$this->to_user_id";
    }

    public function broadcastAs()
    {
        return 'createMessage';
    }
}