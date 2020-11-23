<?php

namespace App\Events;
use App\Message;
use App\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $message;
public $user;
public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message,User $user,$type)
    {
        $this->message = $message;
        $this->user = $user;
        $this->type = $type;

        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('privateMessage.' . $this->message->to_user);
    }
}
