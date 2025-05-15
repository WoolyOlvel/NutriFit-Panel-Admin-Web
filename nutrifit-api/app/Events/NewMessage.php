<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $chatData;

    public function __construct($userId, $chatData)
    {
        $this->userId = $userId;
        $this->chatData = $chatData;

        // No enviar datos sensibles
        unset($this->chatData['chat']['user']['password']);
        unset($this->chatData['chat']['user']['remember_token']);
    }

    public function broadcastOn()
    {
        // Canal privado para el usuario destinatario
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'chat' => $this->chatData['chat'],
            'message' => $this->chatData['message']
        ];
    }

    public function broadcastAs()
    {
        return 'new.message';
    }
}
