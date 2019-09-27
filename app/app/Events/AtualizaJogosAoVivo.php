<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class AtualizaJogosAoVivo implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // private $live;
    // private $excluir;
    // private $cantos;
    // private $gols;
    // private $novo;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->live = $live->toArray();
        // $this->excluir = $excluir;
        
        // $this->cantos = $cantos;
        // $this->gols = $gols;
        // $this->novo = $novo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('ao-vivo');
    }

    public function broadcastWith()
    {
        return ['resultado' => 'ok'];
            // 'live' => $this->live,
            // 'excluir' => $this->excluir,
            // 'cantos'  => $this->cantos,
            // 'gols'    => $this->gols,
            // 'novo'    => $this->novo
        
    }
}
