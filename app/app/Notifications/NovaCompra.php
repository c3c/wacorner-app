<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NovaCompra extends Notification implements ShouldQueue
{
    use Queueable;
    public $venda;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($venda)
    {
        $this->venda = $venda;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Olá!')
                    ->subject('Nova Venda - WACORNER')
                    ->line('Uma venda foi realizada, parabéns! Veja seu saldo acessando seu painel no site WAcorner!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        
        return [
        'icone' => 'cart-plus',
        'titulo' => 'Nova venda',
        'texto' => $this->venda->user->nome.', fez uma compra no valor de R$'.$this->venda->valor.'!',
        'url' => '#',
        ];
    }
}
