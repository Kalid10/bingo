<?php

namespace App\Events;

use App\Models\Cartela;
use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AddCashierPlayerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Game $game;
    public $selectedCartelas;

    public bool $startGame = false;

    public function __construct($game, $selectedCartelas, $startGame = false)
    {
        $this->game = $game;
        $this->selectedCartelas = $selectedCartelas;
        $this->startGame = $startGame;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('cashier-players');
    }

    public function broadcastAs(): string
    {
        return 'cashier-players.' . $this->game->id;
    }
}
