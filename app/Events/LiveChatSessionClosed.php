<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChatSessionClosed implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $sessionId,
        public string $closedByName = 'Guru BK SMAN 4 Jember'
    ) {}

    public function broadcastAs(): string
    {
        return 'session.closed';
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.session.'.$this->sessionId),
        ];
    }
}
