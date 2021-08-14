<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newNotify;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($newNotify, $user)
    {

        $this->newNotify = $newNotify;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification.' . $this->user->id);
    }
    public function broadcastWith()
    {
        
        $unreadNotify = count($this->user->unreadNotifications);
        return ['notification' => $this->newNotify, 'unreadNotify' => $unreadNotify];
    }
}
