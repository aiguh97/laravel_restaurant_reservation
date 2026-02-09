<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Pastikan ini ada
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tableId;
    public $status;

    public function __construct($tableId, $status)
    {
        $this->tableId = $tableId;
        $this->status = $status;
    }

    // Nama channel yang akan didengarkan oleh Flutter
    public function broadcastOn(): array
    {
        return [
            new Channel('restaurant-table'),
        ];
    }

    // Nama event yang akan diterima
    public function broadcastAs(): string
    {
        return 'table.updated';
    }
}
