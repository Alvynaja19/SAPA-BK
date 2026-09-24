<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChatMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  array<string, mixed>  $message
     */
    public function __construct(
        public int $sessionId,
        public array $message,
        public string $status = 'active'
    ) {}

    /**
     * Nama event yang akan didengarkan oleh Laravel Echo di frontend.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Channel private khusus untuk sesi konseling terkait.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.session.'.$this->sessionId),
        ];
    }
}
